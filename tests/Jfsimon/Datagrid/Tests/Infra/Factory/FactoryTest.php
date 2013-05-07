<?php

namespace Jfsimon\Datagrid\Tests\Infra\Factory;

use Jfsimon\Datagrid\Infra\Factory\Factory;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;
use Jfsimon\Datagrid\Service\ExtensionInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

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

    public function testEventDispatcher()
    {
        $schema = Schema::create()
            ->add('id', 'number')
            ->add('name', 'string');

        $options = array(
            'label'  => false,
            'schema' => $schema,
        );

        $data = array(
            array('id' => 1, 'name' => 'first'),
            array('id' => 2, 'name' => 'second'),
        );

        $subscriber = new EventDispatcherTestSubscriber($this, $options, $schema);
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($subscriber);

        $factory = new Factory();
        $factory->setEventDispatcher($dispatcher);
        $factory->createGrid(new Collection($data), $options);
    }
}
