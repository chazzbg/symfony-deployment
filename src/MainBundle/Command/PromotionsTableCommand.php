<?php

namespace MainBundle\Command;

use MainBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PromotionsTableCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('promotions:table')
            ->setDescription('List current promotions');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $promotion_manager = $this->getContainer()->get('promotion_manager');

        $table = new Table($output);

        $table->setHeaders([
            'About',
            'Promotion %'
        ]);

        $general_promotion= $promotion_manager->getGeneralPromotion();

        if($general_promotion > 0){
            $table->addRow(['General promotion', $general_promotion.'%']);
        }


        $categories = $this->getContainer()->get('doctrine')->getRepository('MainBundle:Category')->findAll();

        /** @var Category $category */
        foreach ($categories as $category) {
            if($promotion_manager->hasCategoryPromotion($category)){
                $promotion = $promotion_manager->getCategoryPromotion($category);

                $table->addRow([
                    $category->getName(),
                    $promotion.'%'
                ]);
            }
        }

        $table->render();

    }
}
