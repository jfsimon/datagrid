<?php

namespace Jfsimon\Datagrid\Infra\Extension\Label;

use Jfsimon\Datagrid\Infra\Extension\AbstractExtension;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Component\Row;
use Jfsimon\Datagrid\Model\Data\Collection;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class LabelExtension extends AbstractExtension
{
    const NAME = 'label';

    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('label' => true));
    }

    /**
     * {@inheritdoc}
     */
    public function buildGrid(Grid $grid, Collection $collection, array $options = array())
    {
        if ($options['label']) {
            $grid->getHead()->add(self::NAME, new Row(self::NAME));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildColumn(Column $column, $type, array $options = array())
    {
        if ($options['label']) {
            $column->register(new LabelHandler());
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
