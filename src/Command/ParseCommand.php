<?php

namespace App\Command;

use App\Entity\Store;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseCommand extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('parser:start')

            // the short description shown while running "php bin/console list"
            ->setDescription('Parse main command')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Start collecting prices from all stores');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Task started');
        // TODO
//        $em = $this->
//
//        $tasks = Store

    }
}
