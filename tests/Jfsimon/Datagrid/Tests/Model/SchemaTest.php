<?php

namespace Jfsimon\Datagrid\Tests\Model;

use Jfsimon\Datagrid\Infra\Factory\Factory;
use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Schema;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class SchemaTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionWhenConfigureUnknownColumn()
    {
        $this->setExpectedException('InvalidArgumentException');
        Schema::create()->setOptions('unknown', array());
    }

    public function testGetGrid()
    {
        $factory = new Factory();
        $grid = new Grid();

        $this->assertSame($grid, Schema::create()->bind($factory, $grid)->getGrid());
    }

    public function testExceptionWhenGettingGridOfUnboundSchema()
    {
        $this->setExpectedException('Jfsimon\Datagrid\Exception\WorkflowException');
        Schema::create()->getGrid();
    }

    public function testExceptionWhenGettingColumnsOfUnboundSchema()
    {
        $schema = Schema::create();
        $method = new \ReflectionMethod($schema, 'getColumns');
        $method->setAccessible(true);

        $this->setExpectedException('Jfsimon\Datagrid\Exception\WorkflowException');
        $method->invoke($schema, array());
    }
}
