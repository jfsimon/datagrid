<?php

namespace Jfsimon\Datagrid\Tests\Infra\Factory;

use Jfsimon\Datagrid\Infra\Factory\Factory;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Service\ExtensionInterface;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetExtensions()
    {
        $factory = new Factory();

        $factory
            ->removeExtension('core')
            ->removeExtension('data')
            ->removeExtension('label')
            ->removeExtension('actions')
            ->register(new NamedExtension('e1'), 3)
            ->register(new NamedExtension('e4'), 1)
            ->register(new NamedExtension('e2'), 3)
            ->register(new NamedExtension('e3'), 2)
        ;

        $method = new \ReflectionMethod($factory, 'getExtensions');
        $method->setAccessible(true);
        $extensions = $method->invoke($factory);
        $names = array_map(function (ExtensionInterface $extension) { return $extension->getName(); }, $extensions);

        $this->assertEquals(array('e1', 'e2', 'e3', 'e4'), $names);
    }

    public function testSchemaNotFoundException()
    {
        $factory = new Factory();

        $this->setExpectedException('Jfsimon\Datagrid\Exception\ConfigurationException');
        $factory->createGrid(new Collection(array(array())));
    }
}
