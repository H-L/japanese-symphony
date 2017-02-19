<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListMaidsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:maid:list')
            ->setDescription('list maids')
            ->setHelp("Displays maids")
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $maidRepository = $em->getRepository('AppBundle:Maid');
        $maids = $maidRepository->findAll();
        
        $output->writeln([
            '<info>Maids</info>',
            '<info>============</info>',
        ]);
        foreach ($maids as $maid) {
            $output->writeln('<info>* id :'.$maid->getId().' name : '.$maid->getName().'</info>');
        }
    }
}
