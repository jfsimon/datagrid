<?php

namespace Jfsimon\Datagrid\Tests\Infra\Extension\Data\Formatter;

use Jfsimon\Datagrid\Infra\Extension\Data\Formatter\NumberFormatter;

class NumberFormatterTest extends AbstractFormatterTest
{
    protected function getFormatter()
    {
        \Locale::setDefault('de_AT');

        return new NumberFormatter();
    }

    public function testFormat()
    {
        $this->assertFormat('1', 1);
        $this->assertFormat('1,5', 1.5);
        $this->assertFormat('1234,5', 1234.5);
        $this->assertFormat('12345,912', 12345.9123);
    }

    public function testFormatNull()
    {
        $this->assertFormat('', null);
        $this->assertFormat('NULL', null, array('null_value' => 'NULL'));
    }

    public function testFormatWithGrouping()
    {
        $this->assertFormat('1.234,5', 1234.5, array('grouping' => true));
        $this->assertFormat('12.345,912', 12345.9123, array('grouping' => true));
    }

    public function testFormatWithPrecision()
    {
        $this->assertFormat('1234,50', 1234.5, array('precision' => 2));
        $this->assertFormat('678,92', 678.916, array('precision' => 2));
    }


    public function testFormatWithRoundingMode()
    {
        $this->assertFormat('1234,547', 1234.547, array('rounding_mode' => \NumberFormatter::ROUND_DOWN));
        $this->assertFormat('1234,54', 1234.547, array('precision' => 2, 'rounding_mode' => \NumberFormatter::ROUND_DOWN));
    }
}
