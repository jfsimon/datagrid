<?php

namespace Jfsimon\Datagrid\Model;

use Jfsimon\Datagrid\Model\Component\Cell;
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
     * @throws \LogicException
     *
     * @return Column
     */
    public function register(HandlerInterface $handler, $overwrite = false)
    {
        if (null !== $this->options) {
            throw new \LogicException('Column is configured and cannot accept new handlers.');
        }

        if (!isset($this->handlers[$handler->getType()]) || $overwrite) {
            $this->handlers[$handler->getType()] = $handler;
        }

        return $this;
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return Column
     */
    public function configure($name, array $options = array())
    {
        $resolver = new OptionsResolver();
        foreach ($this->handlers as $handler) {
            $handler->configure($resolver);
        }

        $this->name = $name;
        $this->options = $resolver->resolve($options);

        return $this;
    }

    /**
     * @param Row    $row
     * @param Entity $entity
     *
     * @return Column
     *
     * @throws \LogicException
     */
    public function build(Row $row, Entity $entity)
    {
        if (null === $this->options) {
            throw new \LogicException('Column must be configured before handling.');
        }

        $cell = isset($this->handlers[$row->getType()])
            ? $this->handlers[$row->getType()]->handle($entity, $this->name, $this->options)
            : new Cell();

        $row->add($this->name, $cell);

        return $this;
    }
}
