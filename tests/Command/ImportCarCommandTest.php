<?php

namespace App\Tests\Command;

use App\Command\ImportCarCommand;
use App\Entity\Car;
use Doctrine\ORM\EntityManager;
use JsonStreamingParser\Exception\ParsingException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ImportCarCommandTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    private $cars = [];

    private $baseCar = [
        "name" => "test %s",
        "model" => "model name",
        "vin" => 12345678910110000,
        "price"=> 100000,
        "status"=>"available",
        "brand"=>[
            "name"=>"brand mame %s"
        ],
        "images"=>["test.png"]
    ];

    protected function setUp(): void
    {
        parent::setUp();
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        static::$kernel->getProjectDir();

        for($i=0; $i <= 20; $i++) {
            $car = $this->baseCar;
            $car["name"] = sprintf($this->baseCar["name"], $i);
            $car["brand"]["name"] = sprintf($this->baseCar["brand"]["name"], intdiv($i, 10));
            $car["vin"] = (int)$this->baseCar["vin"] + $i;
            $this->cars[] = $car;
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        //удаляем тыстовые данные из базы
        foreach ($this->em->getRepository(Car::class)->findByVin(array_column($this->cars, 'vin')) as $car) {
            $this->em->remove($car);
        }
        unset($this->cars);
        $this->em->flush();
        $this->em->close();
    }

    public function testExecute()
    {
        // генерируем название времянного json файла содержащего автомобили
        $fileName = sprintf(sys_get_temp_dir().'/cars-import-testing-%s.json', uniqid());

        // записываем json в файл
        file_put_contents($fileName, json_encode($this->cars));

        // выполняем консольную команду команду
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $command = $application->find('app:import-car');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filename' => $fileName
        ]);

        $output = $commandTester->getDisplay();
        //проверяем что вышла запись об успешном выполнении теста
        $this->assertStringContainsString('Импрот завершился успешно, время работы програмы', $output);
        // получем entity первого автомобиля из базы
        $car = $this->em->getRepository(Car::class)->findOneByVin($this->cars[0]['vin']);

        //проверяем что запись есть в базе и entity не пуст
        $this->assertNotEmpty($car);

        //что он соответствует классу Car
        $this->assertInstanceOf(Car::class, $car);

        // что vin из тестовых данных совподает с vin загруженным в базу
        $this->assertEquals((int)$this->cars[0]['vin'], $car->getVin());

        // получемк все тестовые данные из базы
        $cars = $this->em->getRepository(Car::class)->findByVin(array_column($this->cars, 'vin'));
        // проверяем что все данные успешно загружены в базу
        $this->assertCount(count($this->cars), $cars);
        // очищаем переменные, удаляем файл
        unset($car, $cars);
        unlink($fileName);
    }

    /**
     * Тестируем сломанный json файл
     */
    public function testExecuteNotValidJson()
    {
        $fileName = sprintf(sys_get_temp_dir().'/cars-import-testing-%s.json', uniqid());

        file_put_contents($fileName, mb_substr(trim(json_encode($this->cars)), 3));

        $this->expectException(ParsingException::class);

        $kernel = static::createKernel();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $command = $application->find('app:import-car');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filename' => $fileName
        ]);

        unlink($fileName);
    }

    public function testExecuteFileNotFound()
    {
        $this->expectException(\LogicException::class);

        $kernel = static::createKernel();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $command = $application->find('app:import-car');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filename' => 'not-found.json'
        ]);
    }

    public function testExecuteEmptyFileName()
    {
        $this->expectException(\ArgumentCountError::class);

        $kernel = static::createKernel();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $command = $application->find('app:import-car');
        $commandTester = new CommandTester($command);
        $commandTester->execute();
    }

}
