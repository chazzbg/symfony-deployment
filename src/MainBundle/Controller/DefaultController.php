<?php

namespace MainBundle\Controller;

use Faker\Factory;
use MainBundle\Entity\Category;
use MainBundle\Entity\Product;
use MainBundle\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('MainBundle:Default:index.html.twig');
    }


    /**
     * @Route("/seed")
     */
    public function seedData()
    {

        $faker      = Factory::create();
        $manager    = $this->getDoctrine()->getManager();
        $categories = [];


        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $category->setPublished($faker->boolean(80));

            $manager->persist($category);
            $categories[] = $category;
        }


        for($i = 0; $i <100; $i++){
            $product = new Product();
            $product->setName($faker->word);
            $product->setPublished($faker->boolean(80));
            $product->setCategory($faker->randomElement($categories));
            $product->setPrice($faker->randomFloat(null,0.1,5000.0));

            $stock = new Stock();
            $stock->setCount($faker->numberBetween(0,500));
            $product->setStock($stock);

            $manager->persist($product);

            $stock->setProduct($product);

            $manager->persist($stock);
        }

        $manager->flush();
        return new JsonResponse([
            'lol'
        ]);
    }
}
