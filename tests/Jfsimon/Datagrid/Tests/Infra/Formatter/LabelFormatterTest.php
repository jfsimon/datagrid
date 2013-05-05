<?php

namespace Jfsimon\Datagrid\Tests\Infra\Formatter;

use Jfsimon\Datagrid\Infra\Formatter\LabelFormatter;

class LabelFormatterTest extends AbstractFormatterTest
{
    protected function getFormatter()
    {
        return new LabelFormatter();
    }

    public function testFormat()
    {
        $this->assertFormat('Hello world', 'hello world');
        $this->assertFormat('Hello world', 'helloWorld');
        $this->assertFormat('Hello world', 'HelloWorld');
        $this->assertFormat('Hello world', 'hello_world');
    }

    public function testName()
    {
        $this->assertEquals('label', $this->getFormatter()->getName());
    }
}
