<?php

namespace Jfsimon\Datagrid\Infra\Registry;

use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Service\ExtensionInterface;
use Jfsimon\Datagrid\Service\HandlerInterface;
use Jfsimon\Datagrid\Service\RegistryInterface;
use Jfsimon\Datagrid\Service\VisitorInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ExtensionRegistry implements RegistryInterface
{
    /**
     * @var Column[]
     */
    private $columns = array();

    /**
     * @var HandlerInterface[]
     */
    private $handlers = array();

    /**
     * @var VisitorInterface[]
     */
    private $visitors = array();

    /**
     * Registers an extension.
     *
     * @param ExtensionInterface $extension
     *
     * @return ExtensionRegistry
     */
    public function register(ExtensionInterface $extension)
    {
        $this->columns = array_merge($this->columns, $extension->getColumns());
        $this->handlers = array_merge($this->handlers, $extension->getHandlers());
        $this->visitors = array_merge($this->visitors, $extension->getVisitors());

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumn($name)
    {
        return $this->lookup($this->columns, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getSchema($name)
    {
        throw new \InvalidArgumentException('Schema not found.');
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler($name)
    {
        return $this->lookup($this->handlers, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getVisitor($name)
    {
        return $this->lookup($this->visitors, $name);
    }

    /**
     * Looks for named service in given collection.
     *
     * @param array  $collection
     * @param string $name
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    private function lookup(array $collection, $name)
    {
        if (!isset($collection[$name])) {
            throw new \InvalidArgumentException('Service not found.');
        }

        return $collection[$name];
    }
}
