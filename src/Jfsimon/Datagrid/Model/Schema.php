<?php

namespace Jfsimon\Datagrid\Model;

use Jfsimon\Datagrid\Model\Component\Row;
use Jfsimon\Datagrid\Model\Data\Entity;
use Jfsimon\Datagrid\Service\HandlerInterface;
use Jfsimon\Datagrid\Service\RegistryInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Schema
{
    /**
     * @var \Jfsimon\Datagrid\Service\RegistryInterface
     */
    private $registry;

    /**
     * @var array
     */
    private $columns;

    /**
     * @var array
     */
    private $handlers;

    /**
     * @var null|array
     */
    private $cache;

    /**
     * Creates a schema.
     *
     * @param RegistryInterface $registry
     *
     * @return Schema
     */
    public static function create(RegistryInterface $registry)
    {
        $schema = new self();

        return $schema->setRegistry($registry);
    }

    /**
     * @param string        $name
     * @param string|Column $column
     * @param array         $options
     *
     * @return Schema
     */
    public function add($name, $column, array $options = array())
    {
        $this->columns[$name] = array($column, $options);
        $this->cache = null;

        return $this;
    }

    /**
     * @param string|HandlerInterface $handler
     *
     * @return Schema
     */
    public function register($handler)
    {
        $this->handlers[] = $handler;
        $this->cache = null;

        return $this;
    }

    /**
     * @param RegistryInterface $registry
     *
     * @return Schema
     */
    public function setRegistry(RegistryInterface $registry)
    {
        $this->registry = $registry;

        return $this;
    }

    /**
     * @param Row    $row
     * @param Entity $entity
     *
     * @return Schema
     */
    public function build(Row $row, Entity $entity)
    {
        foreach ($this->getColumns() as $column) {
            $column->build($row, $entity);
        }

        return $this;
    }

    /**
     * @return Column[]
     *
     * @throws \LogicException
     */
    private function getColumns()
    {
        if (null === $this->cache) {
            $this->cache = array();

            foreach ($this->columns as $name => $bits) {
                list($column, $options) = $bits;
                $column = $this->resolveColumn($column)->configure($name, $options);

                foreach ($this->handlers as $handler) {
                    $column->register($this->resolveHandler($handler));
                }

                $this->cache[] = $column;
            }
        }

        return $this->cache;
    }

    /**
     * @param mixed $column
     *
     * @return Column
     *
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    private function resolveColumn($column)
    {
        if (is_string($column)) {
            if (null === $this->registry) {
                throw new \LogicException('Registry must be set to resolve column by name.');
            }

            $column = $this->registry->getColumn($column);
        }

        if (!$column instanceof Column) {
            throw new \InvalidArgumentException('A column must be string or instance of Column.');
        }

        return $column;
    }

    /**
     * @param mixed $handler
     *
     * @return HandlerInterface
     *
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    private function resolveHandler($handler)
    {
        if (is_string($handler)) {
            if (null === $this->registry) {
                throw new \LogicException('Registry must be set to resolve handler by name.');
            }

            $handler = $this->registry->getHandler($handler);
        }

        if (!$handler instanceof HandlerInterface) {
            throw new \InvalidArgumentException('A handler must be string or instance of HandlerInterface.');
        }

        return $handler;
    }
}
