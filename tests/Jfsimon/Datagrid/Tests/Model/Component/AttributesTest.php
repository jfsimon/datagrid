<?php

namespace Jfsimon\Datagrid\Tests\Model\Component;

use Jfsimon\Datagrid\Model\Component\Attributes;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class AttributesTest extends \PHPUnit_Framework_TestCase
{
    public function testAttributes()
    {
        $attributes = new Attributes();
        $attributes->set('attr1', 'val1');
        $attributes->set('attr2', 'val2');

        $this->assertEquals(' attr1="val1" attr2="val2"', (string) $attributes);
        $this->assertEquals('val2', $attributes->get('attr2'));
    }

    public function testClasses()
    {
        $attributes = new Attributes();

        $attributes->addClass('cls1');
        $this->assertEquals(' class="cls1"', (string) $attributes);

        $attributes->addClass('cls2');
        $this->assertEquals(' class="cls1 cls2"', (string) $attributes);

        $attributes->removeClass('cls1');
        $this->assertEquals(' class="cls2"', (string) $attributes);
    }
}
