<?php

namespace Jfsimon\Datagrid\Tests\Infra\Extension\Data\Formatter;


use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractFormatterTest extends \PHPUnit_Framework_TestCase
{
    abstract protected function getFormatter();

    protected function assertFormat($expectation, $value, array $options = array())
    {
        $formatter = $this->getFormatter();
        $formatter->configure($resolver = new OptionsResolver());
        $this->assertEquals($expectation, $formatter->format($value, $resolver->resolve($options)));
    }
}
