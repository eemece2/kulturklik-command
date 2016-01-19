<?php

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Command\AgendaCommand;

class AgendaCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application($kernel);

        $application->add(new AgendaCommand());

        $command = $application->find('agenda:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array());

        $this->assertEquals('events number: 2', trim($commandTester->getDisplay()));
    }
}

