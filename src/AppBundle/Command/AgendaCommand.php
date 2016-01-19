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
            ->setDescription('Agenda import')
            ->addArgument(
                'url',
                InputArgument::OPTIONAL,
                'Agenda XML remote URL'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Arguments
        $urlArgument = $input->getArgument('url');

        $xmlUrl = $this->getContainer()->getParameter('agenda_url');
        if($urlArgument) {
            $xmlUrl = $urlArgument;
            $output->writeln('URL: ' . $urlArgument);
        }

        $em = $this->getContainer()->get('doctrine')->getManager();

        $agendaLoader = $this->getContainer()->get('agendaloader');
        $eventsNumber = $agendaLoader->load($xmlUrl, $em);

        $output->writeln('<info>events number: ' . $eventsNumber . '</info>');
    }
}
