<?php
declare(strict_types=1);

namespace App\Tests\Unit\Command;

use App\Tests\Unit\DatabaseInitTrait;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class ImportProductCsvCommandTest extends KernelTestCase
{
    use DatabaseInitTrait;

    private Command $command;

    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->checkIsTestEnvironment($kernel);

        $application = new Application($kernel);
        $application->setAutoExit(true);
        $this->command = $application->find('app:import:csv');

        $this->initDatabase($kernel);
    }

    public function testExecute(): void
    {
        $commandTester = new CommandTester($this->command);

        $response = $commandTester->execute(['command' => $this->command->getName(), 'file' => 'tests/file/stock.csv'], ['test' => true]);

        $this->assertEquals($this->command::SUCCESS, $response);

        $response = $commandTester->execute(['command' => $this->command->getName(), 'file' => 'tests/file/test.xml'], ['test' => true]);

        $this->assertEquals($this->command::FAILURE, $response);
    }
}