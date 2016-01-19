<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AgendaCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('agenda:import')
            ->setDescription('Agenda import');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>events number: 2</info>');
    }
}
