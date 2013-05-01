<?php

namespace Jfsimon\Datagrid\Model;

use Jfsimon\Datagrid\Exception\WorkflowException;
use Jfsimon\Datagrid\Model\Component\Cell\EmptyCell;
use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Component\Row;
use Jfsimon\Datagrid\Model\Data\Entity;
use Jfsimon\Datagrid\Service\HandlerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Column
{
    /**
     * @var Grid
     */
    private $grid;

    /**
     * @var null|string
     */
    private $name;

    /**
     * @var null|array
     */
    private $options;

    /**
     * @var HandlerInterface[]
     */
    private $handlers = array();

    /**
     * @param HandlerInterface $handler
     * @param boolean          $overwrite
     *
     * @throws WorkflowException
     *
     * @return Column
     */
    public function register(HandlerInterface $handler, $overwrite = false)
    {
        if (null !== $this->options) {
            throw WorkflowException::configuredColumn($this, 'handler registration');
        }

        if (!isset($this->handlers[$handler->getType()]) || $overwrite) {
            $this->handlers[$handler->getType()] = $handler;
        }

        return $this;
    }

    /**
     * Tests if handler exists for given row type.
     *
     * @param string $type
     *
     * @return boolean
     */
    public function hasHandler($type)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->getType() === $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array  $options
     *
     * @return Column
     */
    public function configure(array $options = array())
    {
        $resolver = new OptionsResolver();
        foreach ($this->handlers as $handler) {
            $handler->configure($resolver);
        }

        $this->options = $resolver->resolve($options);

        return $this;
    }

    /**
     * @param Grid   $grid
     * @param string $name
     *
     * @return Column
     */
    public function bind(Grid $grid, $name)
    {
        $this->grid = $grid;
        $this->name = $name;

        return $this;
    }

    /**
     * @param Row         $row
     * @param Entity|null $entity
     *
     * @return Column
     *
     * @throws WorkflowException
     */
    public function build(Row $row, Entity $entity = null)
    {
        if (null === $this->options) {
            throw WorkflowException::notConfiguredColumn($this, 'row building');
        }

        $cell = isset($this->handlers[$row->getType()])
            ? $this->handlers[$row->getType()]->handle($this, $entity, $this->options)
            : new EmptyCell();

        $row->add($this->name, $cell);

        return $this;
    }

    /**
     * @return Grid
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }
}
