<?php

namespace MainBundle\Form;

use MainBundle\Entity\Product;
use MainBundle\Transformers\CategoryTransformer;
use MainBundle\Transformers\TagTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{

    private $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
                ->add('price')
                ->add('published')
                ->add('tags', TextType::class)
                ->add('category', TextType::class)
                ->add('save', SubmitType::class, [
                    'label' => 'Save'
                ]);

        $builder->get('tags')->addModelTransformer(new TagTransformer());
        $builder->get('category')->addModelTransformer(
            new CategoryTransformer($this->manager)
        );

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Product::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mainbundle_product';
    }


}