<?php

namespace Jfsimon\Datagrid\Tests\Infra\Extension;

use Jfsimon\Datagrid\Infra\Extension\DataExtension;
use Jfsimon\Datagrid\Model\Column;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DataExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testFormatterNotFoundException()
    {
        $extension = new DataExtension();

        $this->setExpectedException('Jfsimon\Datagrid\Exception\FormatterException');
        $extension->buildColumn(new Column(), 'unknown');
    }
}
