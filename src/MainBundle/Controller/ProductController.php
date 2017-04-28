<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Product;
use MainBundle\Entity\Stock;
use MainBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/product/add", name="product_add")
     * @Template()
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {

        $product = new  Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $stock = new Stock();
            $stock->setProduct($product);
            $stock->setCount('100');

            $manager =$this->getDoctrine()->getManager();

            $manager->persist($product);
            $manager->persist($stock);

            $manager->flush();

            return $this->redirectToRoute('products_list');
        }

        return [ 'form'=> $form->createView() ];

    }


    /**
     * @Route("/product/edit/{product}", name="product_edit")
     * @Template("MainBundle:Product:add.html.twig")
     */
    public function editAction(Product $product, Request $request)
    {

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager =$this->getDoctrine()->getManager();

            $manager->persist($product);

            $manager->flush();
            
            return $this->redirectToRoute('products_list');

        }

        return [ 'form'=> $form->createView() ];
    }
}
