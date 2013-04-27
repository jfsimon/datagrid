<?php

namespace Jfsimon\Datagrid\Tests\Infra\Extension\Data\Formatter;

use Jfsimon\Datagrid\Infra\Extension\Data\Formatter\StringFormatter;

class StringFormatterTest extends AbstractFormatterTest
{
    protected function getFormatter()
    {
        return new StringFormatter();
    }

    public function testFormat()
    {
        $this->assertFormat('hello', 'hello');
        $this->assertFormat('1', 1);
        $this->assertFormat('', null);
    }
}
