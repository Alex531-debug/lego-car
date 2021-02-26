<?php


namespace App\Command;


use App\Service\ImportCar;
use App\Service\SizeFormatService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Консольная команда для импорта автомобилей из JSON файлов
 * потоковый интерпритатор json файла позваляет загружать данные из больших json файлов
 * Class ImportCarCommand
 * @package App\Command
 */
class ImportCarCommand extends Command
{
    private $importCar;

    public function __construct(ImportCar $importCar)
    {
        $this->importCar = $importCar;
        parent::__construct();
    }

    protected static $defaultName = "app:import-car";

    protected function configure()
    {
        $this
            ->addArgument('filename', InputArgument::REQUIRED, 'specify the path to the file')
            ->getDefinition('импорт автомобилей');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln(['Старт импорта автомобилей', '==========================', '']);

        if(!is_file($input->getArgument('filename'))) {// проверяем является ли указзный аргумент файлом
            throw new \LogicException(sprintf('неверно указан название файла: %s', $input->getArgument('filename')));
        }

        if(!is_readable($input->getArgument('filename'))) { //проверяем доступен ли файл для чтения
            throw new \LogicException(sprintf('файл %s недоступен для чтения', $input->getArgument('filename')));
        }

        $start = new \DateTime();
        $startMemory = memory_get_usage();
        $output->writeln('запуск процедуры потокового импорта автомобилей');

        $this->importCar->import($input->getArgument('filename'));

        $end = new \DateTime();

        $programRunMemory = SizeFormatService::getSize(memory_get_usage() - $startMemory);
        $programRunTime = $end->diff($start)->format('%H:%I:%S');

        $output->writeln(sprintf('Импрот завершился успешно, время работы програмы: %s, оперативной памяти задействовано: %s', $programRunTime, $programRunMemory));

        return Command::SUCCESS;
    }
}