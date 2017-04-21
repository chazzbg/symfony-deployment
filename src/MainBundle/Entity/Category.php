<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Product", mappedBy="category")
     */
    private $products;


    /**
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Promotion",mappedBy="category")
     */
    private $promotions;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Category
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }


    /**
     * @param Product $product
     *
     * @return Category
     */
    public function addProducts($product)
    {
        $this->products->add($product);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
}

