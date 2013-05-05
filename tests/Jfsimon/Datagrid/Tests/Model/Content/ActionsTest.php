<?php

namespace Jfsimon\Datagrid\Tests\Model\Content;

use Jfsimon\Datagrid\Model\Actions;
use Jfsimon\Datagrid\Model\Data\Entity;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ActionsTest extends \PHPUnit_Framework_TestCase
{
    /** @dataProvider provideResolveEntityUrlTestData */
    public function testResolveEntityUrl($pattern, $context, $expectation)
    {
        $actions = new Actions();
        $entity = new Entity($context, PropertyAccess::getPropertyAccessor());

        $method = new \ReflectionMethod($actions, 'resolveEntityUrl');
        $method->setAccessible(true);
        $url = $method->invoke($actions, $pattern, $entity);

        $this->assertEquals($expectation, $url);
    }

    public function provideResolveEntityUrlTestData()
    {
        return array(
            array('/articles/{slug}/read', array('slug' => 'hello'), '/articles/hello/read'),
            array('/articles/{slug}/read', array(), '/articles//read'),
            array('/{a}/{b}/{c}', array('a' => '1', 'b' => '2', 'c' => '3'), '/1/2/3'),
        );
    }
}
