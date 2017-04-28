<?php

namespace MainBundle\Transformers;


use Doctrine\ORM\EntityManager;
use MainBundle\Entity\Category;
use MainBundle\Repository\CategoryRepository;



class CategoryTransformerTest extends \PHPUnit_Framework_TestCase
{


    /**
     *
     */
    public function testEmptyTransform()
    {
        $category_mock= $this->createMock(Category::class);
        $category_mock->method('getId')->willReturn(null);


        $category_repo_mock = $this->createMock(CategoryRepository::class);
        $category_repo_mock->method('find')->willReturn(null);
        $manager_mock = $this->createMock(EntityManager::class);
        $manager_mock->method('getRepository')->willReturn($category_repo_mock);

        $transformer = new CategoryTransformer($manager_mock);

        self::assertEmpty($transformer->transform($category_mock));


    }


    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testEmptyReverseTransform()
    {
        $category_mock= $this->createMock(Category::class);


        $category_repo_mock = $this->createMock(CategoryRepository::class);
        $category_repo_mock->method('find')->willReturn(null);
        $manager_mock = $this->createMock(EntityManager::class);
        $manager_mock->method('getRepository')->willReturn($category_repo_mock);

        $transformer = new CategoryTransformer($manager_mock);

        self::assertEmpty($transformer->reverseTransform(''));
    }

    public function testProperTrasform()
    {
        $category_mock= $this->createMock(Category::class);
        $category_mock->method('getId')->willReturn(5);


        $category_repo_mock = $this->createMock(CategoryRepository::class);
        $category_repo_mock->method('find')->willReturn(null);
        $manager_mock = $this->createMock(EntityManager::class);
        $manager_mock->method('getRepository')->willReturn($category_repo_mock);

        $transformer = new CategoryTransformer($manager_mock);

        self::assertEquals(5, $transformer->transform($category_mock));
    }

    public function testProperReverseTrasform()
    {
        $category_mock= $this->createMock(Category::class);
        $category_mock->method('getId')->willReturn(5);


        $category_repo_mock = $this->createMock(CategoryRepository::class);
        $category_repo_mock->method('find')->willReturn($category_mock);
        $manager_mock = $this->createMock(EntityManager::class);
        $manager_mock->method('getRepository')->willReturn($category_repo_mock);

        $transformer = new CategoryTransformer($manager_mock);

        self::assertEquals(5, $transformer->reverseTransform('5')->getId());
    }
}
