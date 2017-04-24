<?php

namespace MainBundle\Command;

use Faker\Factory;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SendNewsletterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('send:newsletter')
            ->setDescription('Send newsletter');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $faker = \Faker\Factory::create();
        $emails = [];

        for($i = 0; $i < 100; $i++){
            $emails[$faker->email] = $faker->firstName.' '.$faker->lastName;
        }

        $mailer = $this->getContainer()->get('mailer');

        $templates = $this->getContainer()->get('templating');
        foreach ($emails as $email => $name){
            $mailer->send(
                Swift_Message::newInstance()->setFrom('admin@localhost.com')
                ->setTo([$email => $name])
                ->setSubject('Monthly newsletter')
                ->setBody($templates->render('MainBundle:Default:newsletter.html.twig', [
                    'firstname'=> $name
                ]),'text/html')
            );
        }

    }

}
