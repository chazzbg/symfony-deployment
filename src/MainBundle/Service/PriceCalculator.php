<?php

namespace MainBundle\Service;

use Doctrine\ORM\EntityManager;
use MainBundle\Entity\Product;

class PriceCalculator
{
    /**
     * @var EntityManager
     */
    protected $emanager;

    protected $promotion;

    protected $category_promotions = [];

    /**
     * PriceCalculator constructor.
     *
     * @param EntityManager $emanager
     */
    public function __construct(EntityManager $emanager)
    {
        $this->emanager = $emanager;
    }


    /**
     * @param Product $product
     *
     * @return float
     */
    public function calculate($product)
    {
        $category = $product->getCategory();

        if (!isset($this->category_promotions[$category->getId()])) {

            $category_prom = $this->emanager
                ->getRepository('MainBundle:Promotion')
                ->fetchBiggestPromotion($category);

            $this->category_promotions[$category->getId()] =
                (int)$category_prom;

        }

        $promotion = $this->category_promotions[$category->getId()];

        if ($promotion === 0) {
            $this->promotion = $promotion = $this->emanager
                ->getRepository('MainBundle:Promotion')
                ->fetchBiggestPromotion();

        }

        return $product->getPrice() - $product->getPrice() * ($promotion / 100);
    }

}
