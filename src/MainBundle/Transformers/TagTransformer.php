<?php

namespace MainBundle\Transformers;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagTransformer implements DataTransformerInterface
{

    public function transform($tagAsArray)
    {
        if (empty($tagAsArray)) {
            return '';
        }

        return implode(',', $tagAsArray);
    }

    public function reverseTransform($tagsAsTring)
    {
        if (empty($tagsAsTring)) {
            return [];
        }

        return explode(',', $tagsAsTring);
    }
}
