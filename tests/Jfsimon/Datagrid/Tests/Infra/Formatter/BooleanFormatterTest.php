<?php

namespace Jfsimon\Datagrid\Tests\Infra\Formatter;

use Jfsimon\Datagrid\Infra\Formatter\BooleanFormatter;

class BooleanFormatterTest extends AbstractFormatterTest
{
    protected function getFormatter()
    {
        return new BooleanFormatter();
    }

    public function testFormatTrueValue()
    {
        $this->assertFormat('yes', true);
        $this->assertFormat('yes', 1);
        $this->assertFormat('yes', 'evaluate to true');
        $this->assertFormat('on', true, array('true_value' => 'on'));
    }

    public function testFormatFalseValue()
    {
        $this->assertFormat('no', false);
        $this->assertFormat('no', 0);
        $this->assertFormat('no', null);
        $this->assertFormat('off', false, array('false_value' => 'off'));
    }
}
