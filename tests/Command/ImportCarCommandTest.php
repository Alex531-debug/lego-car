<?php

namespace App\Tests\Command;

use App\Command\ImportCarCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ImportCarCommandTest extends KernelTestCase
{
    private $importCarCommand;

    public function test__construct(ImportCarCommand $importCarCommand)
    {
        $this->importCarCommand = $importCarCommand;
    }

    public function testExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);
        $application->add($this->importCarCommand);
        $command = $application->find('app:import-car');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'filename' => 'cars-import.json'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('Импрот завершился успешно, время работы програмы', $output);

    }
}
