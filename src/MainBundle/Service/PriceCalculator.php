<?php

namespace MainBundle\Service;

use Doctrine\ORM\EntityManager;
use MainBundle\Entity\Product;
use MainBundle\Repository\PromotionRepository;

class PriceCalculator
{
    /** @var  PromotionManager */
    protected $manager;

    public function __construct(PromotionManager $manager) {
        $this->manager= $manager;
    }


    /**
     * @param Product $product
     *
     * @return float
     */
    public function calculate($product)
    {
        $category    = $product->getCategory();
        $category_id = $category->getId();

        $promotion = $this->manager->getGeneralPromotion();

        if($this->manager->hasCategoryPromotion($category)){
            $promotion = $this->manager->getCategoryPromotion($category);
        }


        return $product->getPrice() - $product->getPrice() * ($promotion / 100);
    }
}
