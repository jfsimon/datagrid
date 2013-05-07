<?php

namespace Jfsimon\Datagrid\Tests\Model\Data;

use Jfsimon\Datagrid\Model\Data\Collection;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testArrayCollection()
    {
        $data = $this->getArrayData();
        $collection = new Collection($data);

        $this->assertEquals($data, $collection->getRaw());
        $this->assertEquals($data[0], $collection->getPeek()->getRaw());
        $this->assertEquals($data[0], $collection->next()->getRaw());
        $this->assertEquals($data[1], $collection->next()->getRaw());
        $this->assertEquals($data[2], $collection->getPeek()->getRaw());

        $collection->rewind();
        $this->assertEquals($data[0], $collection->next()->getRaw());
    }

    public function testIteratorCollection()
    {
        $array = $this->getArrayData();
        $data = new \ArrayIterator($array);
        $collection = new Collection($data);

        $this->assertSame($data, $collection->getRaw());
        $this->assertEquals($array[0], $collection->getPeek()->getRaw());
        $this->assertEquals($array[0], $collection->next()->getRaw());
        $this->assertEquals($array[1], $collection->next()->getRaw());
        $this->assertEquals($array[2], $collection->getPeek()->getRaw());

        $collection->rewind();
        $this->assertEquals($array[0], $collection->next()->getRaw());
    }

    public function testIteratorAggregateCollection()
    {
        $array = $this->getArrayData();
        $iterator = new \ArrayIterator($array);
        $data = new DelegatingIterator($iterator);
        $collection = new Collection($data);

        $this->assertSame($iterator, $collection->getRaw());
        $this->assertEquals($array[0], $collection->getPeek()->getRaw());
        $this->assertEquals($array[0], $collection->next()->getRaw());
        $this->assertEquals($array[1], $collection->next()->getRaw());
        $this->assertEquals($array[2], $collection->getPeek()->getRaw());

        $collection->rewind();
        $this->assertEquals($array[0], $collection->next()->getRaw());
    }

    public function testExceptionOnInvalidData()
    {
        $this->setExpectedException('Jfsimon\Datagrid\Exception\DataException');
        new Collection('invalid');
    }

    public function testExceptionOnInvalidDataType()
    {
        $collection = new Collection(array());
        $type = new \ReflectionProperty($collection, 'type');
        $type->setAccessible(true);
        $type->setValue($collection, 'invalid');

        $this->setExpectedException('Jfsimon\Datagrid\Exception\DataException');
        $collection->getRaw();
    }

    private function getArrayData()
    {
        return array(
            array('id' => 1, 'name' => 'first'),
            array('id' => 2, 'name' => 'second'),
            array('id' => 3, 'name' => 'third'),
        );
    }
}
