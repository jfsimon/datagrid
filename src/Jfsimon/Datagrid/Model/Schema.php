<?php

namespace Jfsimon\Datagrid\Model;

use Jfsimon\Datagrid\Exception\WorkflowException;
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
     * @return Schema
     */
    public static function create()
    {
        return new self();
    }

    /**
     * Adds a column type.
     *
     * @param string        $name
     * @param string|Column $type
     * @param array         $options
     *
     * @return Schema
     */
    public function add($name, $type, array $options = array())
    {
        $this->types[$name] = array('name' => $type, 'options' => $options);
        $this->columns = null;

        return $this;
    }

    /**
     * Tests column existence.
     *
     * @param string $name
     *
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->types[$name]);
    }

    /**
     * Removes a column.
     *
     * @param string $name
     */
    public function remove($name)
    {
        unset($this->types[$name]);
    }

    /**
     * Merges named column options.
     *
     * @param string $name
     * @param array  $options
     *
     * @throws \InvalidArgumentException
     *
     * @return Schema
     */
    public function setOptions($name, array $options)
    {
        if (!isset($this->types[$name])) {
            throw new \InvalidArgumentException('Invalid name');
        }

        $this->types[$name]['options'] = array_merge($this->types[$name]['options'], $options);

        return $this;
    }

    /**
     * Binds schema to grid.
     *
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
     * Builds row.
     *
     * @param Row         $row
     * @param Entity|null $entity
     * @param array       $options
     */
    public function build(Row $row, Entity $entity = null, array $options)
    {
        foreach ($this->getColumns($options) as $name => $column) {
            $column
                ->bind($this->grid, $name)
                ->build($row, $entity)
            ;
        }
    }

    /**
     * Returns bound grid.
     *
     * @throws WorkflowException
     *
     * @return Grid|null
     */
    public function getGrid()
    {
        if (null === $this->grid) {
            throw WorkflowException::unboundSchema('grid access');
        }

        return $this->grid;
    }

    /**
     * Creates columns.
     *
     * @param array $globalOptions
     *
     * @throws WorkflowException
     *
     * @return Column[]
     */
    private function getColumns(array $globalOptions)
    {
        if (null !== $this->columns) {
            return $this->columns;
        }

        if (null === $this->factory) {
            throw WorkflowException::unboundSchema('columns creation');
        }

        $this->columns = array();

        foreach ($this->types as $name => $type) {
            $this->columns[$name] = $this->factory->createColumn($type['name'], array_merge($globalOptions, $type['options']));
        }

        return $this->columns;
    }
}
