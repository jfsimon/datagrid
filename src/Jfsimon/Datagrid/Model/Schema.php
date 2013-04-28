<?php

namespace Jfsimon\Datagrid\Model;

use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Component\Row;
use Jfsimon\Datagrid\Model\Data\Entity;
use Jfsimon\Datagrid\Service\FactoryInterface;

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
     * @var FactoryInterface|null
     */
    private $factory;

    /**
     * @var Grid|null
     */
    private $grid;

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
     * @param Grid             $grid
     *
     * @return Schema
     */
    public function bind(FactoryInterface $factory, Grid $grid)
    {
        $this->factory = $factory;
        $this->grid = $grid;

        return $this;
    }

    /**
     * @param Row         $row
     * @param Entity|null $entity
     */
    public function build(Row $row, Entity $entity = null)
    {
        foreach ($this->getColumns() as $name => $column) {
            $column
                ->bind($this->grid, $name)
                ->build($row, $entity)
            ;
        }
    }

    /**
     * @throws \LogicException
     *
     * @return Grid|null
     */
    public function getGrid()
    {
        if (null === $this->grid) {
            throw new \LogicException('Schema must be bound to access grid.');
        }

        return $this->grid;
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
            throw new \LogicException('Schema must be bound to create columns.');
        }

        $this->columns = array();

        foreach ($this->types as $name => $bits) {
            list($type, $options) = $bits;
            $this->columns[$name] = $this->factory->createColumn($type, $options);
        }

        return $this->columns;
    }
}
