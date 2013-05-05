<?php

namespace Jfsimon\Datagrid\Tests\Model;

use Jfsimon\Datagrid\Infra\Handler\LabelHandler;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Row;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ColumnTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionWhenRegisteringHandlerOnConfiguredColumn()
    {
        $column = new Column();
        $column->configure(array());

        $this->setExpectedException('Jfsimon\Datagrid\Exception\WorkflowException');
        $column->register(new LabelHandler());
    }

    public function testExceptionWhenBuildingNonConfiguredColumn()
    {
        $column = new Column();

        $this->setExpectedException('Jfsimon\Datagrid\Exception\WorkflowException');
        $column->build(new Row('data'));
    }
}
