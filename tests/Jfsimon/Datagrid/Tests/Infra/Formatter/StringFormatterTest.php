<?php

namespace Jfsimon\Datagrid\Tests\Infra\Formatter;

use Jfsimon\Datagrid\Infra\Formatter\StringFormatter;

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
