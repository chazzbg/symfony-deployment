<?php
/**
 * Created by PhpStorm.
 * User: chazz
 * Date: 27.04.17
 * Time: 20:05
 *
 */

namespace MainBundle\Transformers;

use Doctrine\ORM\EntityManager;
use MainBundle\Entity\Category;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CategoryTransformer implements DataTransformerInterface
{
    /** @var  EntityManager */
    private $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }


    /**
     * @param Category $category
     */
    public function transform($category)
    {
        if(!$category){
            return '';
        }

        return $category->getId();
    }


    /**
     * @param int $category_id
     */
    public function reverseTransform($category_id)
    {
        $repo = $this->manager->getRepository('MainBundle:Category');

        $category = $repo->find($category_id);

        if(!$category){
            throw new TransformationFailedException('Category not found');
        }


        return $category;
    }
}
