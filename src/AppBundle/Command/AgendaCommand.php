<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManager;

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
            )
            ->addOption(
                'clear',
                null,
                InputOption::VALUE_NONE,
                'If set, first remove all events'
            )
            ->addOption(
                'nodb',
                null,
                InputOption::VALUE_NONE,
                'If set, not use DB'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Arguments
        $urlArgument = $input->getArgument('url');
        // Options
        $clearOption = $input->getOption('clear');
        $nodbOption = $input->getOption('nodb');

        if($nodbOption) {
            $em = $this->getContainer()->get('nodbEntityManager');
        } else {
            $em = $this->getContainer()->get('doctrine')->getManager();
        }

        $xmlUrl = $this->getContainer()->getParameter('agenda_url');
        if($urlArgument) {
            $xmlUrl = $urlArgument;
            $output->writeln('URL: ' . $urlArgument);
        }

        if($clearOption && !$nodbOption) {
            $this->removeAllEvents($em);
        }

        $agendaLoader = $this->getContainer()->get('agendaloader');
        $eventsNumber = $agendaLoader->load($xmlUrl, $em);

        $output->writeln('<info>events number: ' . $eventsNumber . '</info>');
    }

    protected function removeAllEvents(EntityManager $em)
    {
        $q = $em->createQuery('delete from AppBundle\Entity\Event');

        return $q->execute();
    }
}
