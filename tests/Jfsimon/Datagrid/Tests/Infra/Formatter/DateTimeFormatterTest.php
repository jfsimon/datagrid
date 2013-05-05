<?php

namespace Jfsimon\Datagrid\Tests\Infra\Formatter;

use Jfsimon\Datagrid\Infra\Formatter\DateTimeFormatter;

class DateTimeFormatterTest extends AbstractFormatterTest
{
    protected function getFormatter()
    {
        \Locale::setDefault('de_AT');

        return new DateTimeFormatter();
    }

    /** @dataProvider provideFormatTestData */
    public function testFormat($dateFormat, $timeFormat, $pattern, $output, $input)
    {
        $options = array('time_zone' => 'UTC');

        if (null !== $dateFormat) {
            $options['date_format'] = $dateFormat;
        }

        if (null !== $timeFormat) {
            $options['time_format'] = $timeFormat;
        }

        if (null !== $pattern) {
            $options['pattern'] = $pattern;
        }

        $this->assertFormat($output, new \DateTime($input), $options);
    }

    public function provideFormatTestData()
    {
        return array(
            array(\IntlDateFormatter::SHORT, null, null, '03.02.10 04:05', '2010-02-03 04:05:00 UTC'),
            array(\IntlDateFormatter::MEDIUM, null, null, '03.02.2010 04:05', '2010-02-03 04:05:00 UTC'),
            array(\IntlDateFormatter::LONG, null, null, '03. Februar 2010 04:05', '2010-02-03 04:05:00 UTC'),
            array(\IntlDateFormatter::FULL, null, null, 'Mittwoch, 03. Februar 2010 04:05', '2010-02-03 04:05:00 UTC'),
            array(\IntlDateFormatter::SHORT, \IntlDateFormatter::NONE, null, '03.02.10', '2010-02-03 00:00:00 UTC'),
            array(\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE, null, '03.02.2010', '2010-02-03 00:00:00 UTC'),
            array(\IntlDateFormatter::LONG, \IntlDateFormatter::NONE, null, '03. Februar 2010', '2010-02-03 00:00:00 UTC'),
            array(\IntlDateFormatter::FULL, \IntlDateFormatter::NONE, null, 'Mittwoch, 03. Februar 2010', '2010-02-03 00:00:00 UTC'),
            array(null, \IntlDateFormatter::SHORT, null, '03.02.2010 04:05', '2010-02-03 04:05:00 UTC'),
            array(null, \IntlDateFormatter::MEDIUM, null, '03.02.2010 04:05:06', '2010-02-03 04:05:06 UTC'),
            array(null, \IntlDateFormatter::LONG, null, '03.02.2010 04:05:06 GMT+00:00', '2010-02-03 04:05:06 UTC'),
            // see below for extra test case for time format FULL
            array(\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT, null, '04:05', '1970-01-01 04:05:00 UTC'),
            array(\IntlDateFormatter::NONE, \IntlDateFormatter::MEDIUM, null, '04:05:06', '1970-01-01 04:05:06 UTC'),
            array(\IntlDateFormatter::NONE, \IntlDateFormatter::LONG, null, '04:05:06 GMT+00:00', '1970-01-01 04:05:06 UTC'),
            array(null, null, 'yyyy-MM-dd HH:mm:00', '2010-02-03 04:05:00', '2010-02-03 04:05:00 UTC'),
            array(null, null, 'yyyy-MM-dd HH:mm', '2010-02-03 04:05', '2010-02-03 04:05:00 UTC'),
            array(null, null, 'yyyy-MM-dd HH', '2010-02-03 04', '2010-02-03 04:00:00 UTC'),
            array(null, null, 'yyyy-MM-dd', '2010-02-03', '2010-02-03 00:00:00 UTC'),
            array(null, null, 'yyyy-MM', '2010-02', '2010-02-01 00:00:00 UTC'),
            array(null, null, 'yyyy', '2010', '2010-01-01 00:00:00 UTC'),
            array(null, null, 'dd-MM-yyyy', '03-02-2010', '2010-02-03 00:00:00 UTC'),
            array(null, null, 'HH:mm:ss', '04:05:06', '1970-01-01 04:05:06 UTC'),
            array(null, null, 'HH:mm:00', '04:05:00', '1970-01-01 04:05:00 UTC'),
            array(null, null, 'HH:mm', '04:05', '1970-01-01 04:05:00 UTC'),
            array(null, null, 'HH', '04', '1970-01-01 04:00:00 UTC'),
        );
    }

    public function testTransformEmpty()
    {
        $this->assertFormat('', null);
        $this->assertFormat('NULL', null, array('null_value' => 'NULL'));
    }

    public function testExceptionOnInvalidData()
    {
        $this->setExpectedException('Jfsimon\Datagrid\Exception\FormatterException');
        $this->getFormatter()->format('invalid');
    }
}
