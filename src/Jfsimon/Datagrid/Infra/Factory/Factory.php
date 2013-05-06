<?php

namespace Jfsimon\Datagrid\Infra\Factory;

use Jfsimon\Datagrid\Exception\ConfigurationException;
use Jfsimon\Datagrid\Infra\Extension\ActionsExtension;
use Jfsimon\Datagrid\Infra\Extension\CoreExtension;
use Jfsimon\Datagrid\Infra\Extension\DataExtension;
use Jfsimon\Datagrid\Infra\Extension\LabelExtension;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Event\Events;
use Jfsimon\Datagrid\Model\Event\GridEvent;
use Jfsimon\Datagrid\Model\Event\OptionsEvent;
use Jfsimon\Datagrid\Model\Event\SchemaEvent;
use Jfsimon\Datagrid\Service\ExtensionInterface;
use Jfsimon\Datagrid\Service\FactoryInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Factory implements FactoryInterface
{
    /**
     * @var array
     */
    private $extensions = array();

    /**
     * @var boolean
     */
    private $sorted = true;

    /**
     * @var EventDispatcherInterface|null
     */
    private $dispatcher;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this
            ->register(new CoreExtension(), 100)
            ->register(new DataExtension(), 0)
            ->register(new LabelExtension(), -50)
            ->register(new ActionsExtension(), 50)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function register(ExtensionInterface $extension, $priority = 0)
    {
        $this->sorted = false;
        $this->extensions[$extension->getName()] = array(
            'extension' => $extension,
            'priority'  => $priority,
            'index'     => count($this->extensions),
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEventDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeExtension($name)
    {
        if (isset($this->extensions[$name])) {
            unset($this->extensions[$name]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function createGrid(Collection $collection, array $options = array())
    {
        $extensions = $this->getExtensions();
        $grid = new Grid();

        // options resolution

        if (null !== $this->dispatcher) {
            $this->dispatcher->dispatch(Events::OPTIONS_SET, $event = new OptionsEvent($options));
            $options = $event->getOptions();
        }

        $resolver = new OptionsResolver();
        foreach ($extensions as $extension) {
            $extension->configure($resolver);
        }
        $options = $resolver->resolve($options);

        if (null !== $this->dispatcher) {
            $this->dispatcher->dispatch(Events::OPTIONS_RESOLVED, $event = new OptionsEvent($options));
            $options = $event->getOptions();
        }

        // schema building

        $schema = null;
        foreach ($extensions as $extension) {
            $schema = $extension->guessSchema($collection->getPeek(), $options);
            if (null !== $schema) {
                break;
            }
        }
        if (null === $schema) {
            throw ConfigurationException::schemaNotFound(array_keys($this->extensions));
        }

        if (null !== $this->dispatcher) {
            $this->dispatcher->dispatch(Events::SCHEMA_GUESSED, $event = new SchemaEvent($schema));
            $schema = $event->getSchema();
        }

        $schema->bind($this, $grid);

        foreach ($extensions as $extension) {
            $extension->buildSchema($schema, $collection, $options);
        }

        if (null !== $this->dispatcher) {
            $this->dispatcher->dispatch(Events::SCHEMA_BUILT, $event = new SchemaEvent($schema));
            $schema = $event->getSchema();
        }

        // grid building

        foreach ($extensions as $extension) {
            $extension->buildGrid($grid, $schema, $collection, $options);
        }

        if (null !== $this->dispatcher) {
            $this->dispatcher->dispatch(Events::GRID_BUILT, $event = new GridEvent($grid));
            $grid = $event->getGrid();
        }

        foreach ($extensions as $extension) {
            $extension->visit($grid, $options);
        }

        if (null !== $this->dispatcher) {
            $this->dispatcher->dispatch(Events::GRID_VISITED, $event = new GridEvent($grid));
            $grid = $event->getGrid();
        }

        return $grid;
    }

    /**
     * {@inheritdoc}
     */
    public function createColumn($type, array $options = array())
    {
        $column = new Column();
        foreach ($this->getExtensions() as $extension) {
            $extension->buildColumn($column, $type, $options);
        }

        return $column->configure($options);
    }

    /**
     * Returns sorted list of extensions.
     *
     * @return ExtensionInterface[]
     */
    private function getExtensions()
    {
        if (!$this->sorted) {
            usort($this->extensions, function (array $a, array $b) {
                return $a['priority'] === $b['priority']
                    ? ($a['index'] > $b['index'] ? 1 : -1)
                    : ($a['priority'] > $b['priority'] ? -1 : 1);
            });
            $this->sorted = true;
        }

        return array_map(function (array $entry) {
            return $entry['extension'];
        }, $this->extensions);
    }
}
