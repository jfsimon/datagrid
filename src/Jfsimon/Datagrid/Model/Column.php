<?php

namespace Jfsimon\Datagrid\Model;

use Jfsimon\Datagrid\Model\Component\Cell\EmptyCell;
use Jfsimon\Datagrid\Model\Component\Row;
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
     * @param HandlerInterface[] $handlers
     */
    public function __construct(array $handlers = array())
    {
        foreach ($handlers as $handler) {
            $this->register($handler);
        }
    }

    /**
     * @param HandlerInterface $handler
     *
     * @return Column
     *
     * @throws \LogicException
     */
    public function register(HandlerInterface $handler)
    {
        if (null !== $this->options) {
            throw new \LogicException('Column is configured and cannot accept new handlers.');
        }

        $this->handlers[] = $handler;

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
     * @param Row   $row
     * @param mixed $data
     *
     * @return Column
     *
     * @throws \LogicException
     */
    public function build(Row $row, $data)
    {
        if (null === $this->options) {
            throw new \LogicException('Column must be configured before handling.');
        }

        $handler = $this->getHandler($data, $row->getType());
        $cell = $handler ? $handler->handle($data, $this->name, $this->options) : new EmptyCell();
        $row->addCell($this->name, $cell);

        return $this;
    }

    /**
     * @param mixed  $data
     * @param string $type
     *
     * @return HandlerInterface|null
     */
    private function getHandler($data, $type)
    {
        foreach ($this->handlers as $handler) {
            if ($type === $handler->getType() && $handler->supports($data)) {
                return $handler;
            }
        }

        return null;
    }
}
