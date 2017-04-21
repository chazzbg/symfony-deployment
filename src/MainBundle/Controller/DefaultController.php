<?php

namespace MainBundle\Controller;

use Faker\Factory;
use MainBundle\Entity\Category;
use MainBundle\Entity\Product;
use MainBundle\Entity\Stock;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @property  Container container
 */
class DefaultController extends Controller
{
    const NUM_RESULT = 9;

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

    /**
     * @Route("/dbal/{id}/{name}")
     */
    public function dbalAction($id,$name){


        $conn = $this->get('doctrine.dbal.connection_factory')->createConnection([
            'driver'=> 'pdo_mysql',
            'dbname'=>'softfund_doctrine',
            'user'=>'softfund',
            'password'=>'softfund',
            'host'=> '127.0.0.1',
            'port'=> null
        ]);

        $result = $conn->prepare('SELECT * FROM product WHERE id = :id AND name like :name');

        $result->bindParam(':id', $id);
        $result->bindParam(':name', $name);

        $data = $result->execute();


        dump($result->fetch());


        return new JsonResponse([
           'succes'=> true
        ]);
    }


    /**
     * @Route("/repos")
     */
    public function reposAction()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('MainBundle:Category');

        dump($repo->findAll());
        return $this->render('::base.html.twig');

    }

    /**
     * @Route("/query/{category}/{published}")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function queryAction($category, $published)
    {
        $cat = $this->getDoctrine()
                    ->getRepository('MainBundle:Category')
                    ->find($category);

        $result = $this->getDoctrine()
                       ->getManager()
                       ->getRepository('MainBundle:Product')
                        ->findByPublishedAndCategory($published, $cat);

        dump($result);

        return $this->render('::base.html.twig');
    }

    /**
     * @Route("/simple_pagination", name="product_pages")
     * @Template()
     * @param Request $request
     *
     * @return array
     */
    public function productsAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $repo = $manager->getRepository('MainBundle:Product');


        $product_count  = $repo->fetchProductCount();
        $products = $repo->fetchProductsPaginated($request->get('page',1), self::NUM_RESULT);

        $pages= ceil($product_count/self::NUM_RESULT);


        return compact('products','product_count','pages');
    }


    /**
     * @Route("/products")
     * @Template()
     * @throws \LogicException
     */
    public function productsKnpAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $query = $this->getDoctrine()->getRepository('MainBundle:Product')->createQueryBuilder('p')
            ->select('p');

        $pagination=  $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('p', 1),
            self::NUM_RESULT
        );

        $calc = $this->get('price_calculator');

        $max_promotion = $this->get('promotion_manager')->getGeneralPromotion();

        return compact('pagination','max_promotion','calc');
    }


    public function newAction()
    {
        // the container will instantiate a new MessageGenerator()
        $message_generator = $this->container->get('app.message_generator');


        $message = $message_generator->getHappyMessage();
        $this->addFlash('success', $message);
    }
}
