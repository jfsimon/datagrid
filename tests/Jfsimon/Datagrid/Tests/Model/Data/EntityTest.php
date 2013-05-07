<?php

namespace Jfsimon\Datagrid\Tests\Model\Data;

use Jfsimon\Datagrid\Model\Data\Entity;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class EntityTest extends \PHPUnit_Framework_TestCase
{
    public function testArrayData()
    {
        $data = array('property' => 'value');
        $entity = new Entity($data, PropertyAccess::getPropertyAccessor());

        $this->assertEquals($data, $entity->getRaw());
    }

    public function testObjectData()
    {
        $data = new \stdClass();
        $entity = new Entity($data, PropertyAccess::getPropertyAccessor());

        $this->assertSame($data, $entity->getRaw());
    }

    public function testFieldAccess()
    {
        $data = array('property' => 'value');
        $entity = new Entity($data, PropertyAccess::getPropertyAccessor());

        $this->assertEquals('value', $entity->get('property'));
        $this->assertEquals('value', $entity->get('anything', 'property'));
    }

    public function testMapping()
    {
        $data = array('property' => 'value');
        $entity = new Entity($data, PropertyAccess::getPropertyAccessor(), array('anything' => 'property'));

        $this->assertEquals('value', $entity->get('anything'));
    }

    public function testId()
    {
        $data = array('property' => 'value');
        $entity = new Entity($data, PropertyAccess::getPropertyAccessor(), array(), 'property');

        $this->assertEquals('value', $entity->getId());
    }

    public function testExceptionOnInvalidData()
    {
        $this->setExpectedException('Jfsimon\Datagrid\Exception\DataException');
        new Entity('invalid', PropertyAccess::getPropertyAccessor());
    }
}
