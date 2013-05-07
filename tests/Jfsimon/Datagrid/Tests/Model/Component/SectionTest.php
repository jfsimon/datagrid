<?php

namespace Jfsimon\Datagrid\Tests\Model\Component;

use Jfsimon\Datagrid\Model\Component\Section;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class SectionTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionOnRenderingUnboundComponent()
    {
        $renderer = $this->getMock('Jfsimon\Datagrid\Service\RendererInterface');
        $component = new Section();

        $this->setExpectedException('Jfsimon\Datagrid\Exception\WorkflowException');
        $component->render($renderer);
    }
}
