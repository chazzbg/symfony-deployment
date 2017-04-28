<?php
/**
 * Created by PhpStorm.
 * User: chazz
 * Date: 28.04.17
 * Time: 13:41
 *
 */

namespace MainBundle\Transformers;


class TagTransformerTest extends \PHPUnit_Framework_TestCase
{

    public function testEmptyTransforms()
    {
        $transform = new TagTransformer();

        self::assertEmpty($transform->transform([]));
        self::assertEmpty($transform->reverseTransform(''));

    }

    public function testProperTransforms()
    {
        $transform = new TagTransformer();

        self::assertEquals('one,two,three', $transform->transform(['one', 'two', 'three']));
        self::assertEquals(['one', 'two', 'three'], $transform->reverseTransform('one,two,three'));

    }
}
