<?php

namespace Jfsimon\Datagrid\Tests\Infra\Handler;

use Jfsimon\Datagrid\Infra\Handler\DataActionsHandler;
use Jfsimon\Datagrid\Model\Column;

class DataActionsHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionWhenNoActions()
    {
        $handler = new DataActionsHandler();

        $this->setExpectedException('Jfsimon\Datagrid\Exception\ConfigurationException');
        $handler->handle(new Column(), null, array('actions' => null));
    }
}
