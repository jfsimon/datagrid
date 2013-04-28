<?php

namespace Jfsimon\Datagrid\Infra\Extension;

use Jfsimon\Datagrid\Infra\Extension\AbstractExtension;
use Jfsimon\Datagrid\Infra\Extension\Label\LabelHandler;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Component\Row;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class LabelExtension extends AbstractExtension
{
    const NAME = 'label';

    /**
     * @var LabelHandler
     */
    private $handler;

    /**
     * @param LabelHandler $handler
     */
    public function __construct(LabelHandler $handler = null)
    {
        $this->handler = $handler ?: new LabelHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $this->handler->configure($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function buildGrid(Grid $grid, Schema $schema, Collection $collection, array $options = array())
    {
        if ($options[self::NAME]) {
            $schema->build($row = new Row(self::NAME));
            $grid->getHead()->add(self::NAME, $row);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildColumn(Column $column, $type, array $options = array())
    {
        if ($options[self::NAME]) {
            $column->register($this->handler);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
