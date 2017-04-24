<?php

namespace MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InspireMeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('inspire:me')
            ->setDescription('Get inspirational quote')
            ->addArgument('name', InputArgument::OPTIONAL, 'Your greeting name')
            ->addOption('no-greeting', 'g', InputOption::VALUE_NONE,'Disable greeting')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        if( ! $input->getOption('no-greeting')){
            $name = $input->getArgument('name');

            $output->writeln('Hello '. $name.', take this inspirational quote!');
        }

        $quotes = [
            'Your work is going to fill a large part of your life, and the only way to be truly satisfied is to do what you believe is great work. And the only way to do great work is to love what you do. If you haven\'t found it yet, keep looking. Don\'t settle. As with all matters of the heart, you\'ll know when you find it.',
            'The best preparation for tomorrow is doing your best today.',
            'We must let go of the life we have planned, so as to accept the one that is waiting for us.'
        ];

        $quote = $quotes[array_rand($quotes)];

        /** @var FormatterHelper $formatter */
        $formatter = $this->getHelper('formatter');

        $quote = $formatter->truncate($quote, 50, '!!!');

        $formated_quote = $formatter->formatSection('Quote', $quote);

        $output->writeln($formated_quote);
    }

}
