<?php

namespace Jfsimon\Datagrid\Tests\Model\Component;

use Jfsimon\Datagrid\Model\Component\Row;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class RowTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionOnRenderingUnboundComponent()
    {
        $renderer = $this->getMock('Jfsimon\Datagrid\Service\RendererInterface');
        $component = new Row('type');;

        $this->setExpectedException('Jfsimon\Datagrid\Exception\WorkflowException');
        $component->render($renderer);
    }
}
