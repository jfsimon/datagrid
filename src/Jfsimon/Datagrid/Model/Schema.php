<?php

namespace Jfsimon\Datagrid\Model;

use Jfsimon\Datagrid\Model\Component\Row;
use Jfsimon\Datagrid\Model\Data\Entity;
use Jfsimon\Datagrid\Service\FactoryInterface;
use Jfsimon\Datagrid\Service\HandlerInterface;
use Jfsimon\Datagrid\Service\RegistryInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Schema
{
    /**
     * @var array
     */
    private $types = array();

    /**
     * @var Column[]|null
     */
    private $columns;

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param string        $name
     * @param string|Column $type
     * @param array         $options
     *
     * @return Schema
     */
    public function add($name, $type, array $options = array())
    {
        $this->types[$name] = array($type, $options);
        $this->columns = null;

        return $this;
    }

    /**
     * @param FactoryInterface $factory
     *
     * @return Schema
     */
    public function setFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * @param Row    $row
     * @param Entity $entity
     */
    public function build(Row $row, Entity $entity)
    {
        foreach ($this->getColumns() as $column) {
            $column->build($row, $entity);
        }
    }

    /**
     * @throws \LogicException
     *
     * @return Column[]
     */
    private function getColumns()
    {
        if (null !== $this->columns) {
            return $this->columns;
        }

        if (null === $this->factory) {
            throw new \LogicException('Factory must be set to create columns.');
        }

        $this->columns = array();

        foreach ($this->types as $name => $bits) {
            list($type, $options) = $bits;
            $this->columns[$name] = $this->factory->createColumn($type, $options);
        }

        return $this->columns;
    }
}
