<?php

namespace Jfsimon\Datagrid\Tests\Infra\Factory;

use Jfsimon\Datagrid\Model\Event\GridEvent;
use Jfsimon\Datagrid\Model\Event\OptionsEvent;
use Jfsimon\Datagrid\Model\Event\SchemaEvent;
use Jfsimon\Datagrid\Model\Schema;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Jfsimon\Datagrid\Model\Event\Events;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class EventDispatcherTestSubscriber implements EventSubscriberInterface
{
    private $test;
    private $options;
    private $schema;
    private $updatedSchema;
    private $updatedGrid;

    public function __construct(\PHPUnit_Framework_TestCase $test, array $options, Schema $schema)
    {
        $this->test = $test;
        $this->options = $options;
        $this->schema = $schema;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::OPTIONS_SET      => 'onOptionsSet',
            Events::OPTIONS_RESOLVED => 'onOptionsResolved',
            Events::SCHEMA_GUESSED   => 'onSchemaGuessed',
            Events::SCHEMA_BUILT     => 'onSchemaBuilt',
            Events::GRID_BUILT       => 'onGridBuilt',
            Events::GRID_VISITED     => 'onGridVisited',
        );
    }

    public function onOptionsSet(OptionsEvent $event)
    {
        $options = $event->getOptions();
        $this->test->assertEquals($this->options, $event->getOptions());
        $options['label'] = true;
        $event->setOptions($options);
    }

    public function onOptionsResolved(OptionsEvent $event)
    {
        $options = $event->getOptions();
        $this->test->assertTrue($options['label']);
    }

    public function onSchemaGuessed(SchemaEvent $event)
    {
        $this->test->assertSame($this->schema, $event->getSchema());
        $this->updatedSchema = Schema::create()->add('name', 'string');
        $event->setSchema($this->updatedSchema);
    }

    public function onSchemaBuilt(SchemaEvent $event)
    {
        $this->test->assertSame($this->updatedSchema, $event->getSchema());
        $this->test->assertFalse($event->getSchema()->has('id'));
    }

    public function onGridBuilt(GridEvent $event)
    {
        $this->updatedGrid = clone $event->getGrid();
        $event->setGrid($this->updatedGrid);
    }

    public function onGridVisited(GridEvent $event)
    {
        $this->test->assertSame($this->updatedGrid, $event->getGrid());
    }
}
