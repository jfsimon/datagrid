<?php

namespace Jfsimon\Datagrid\Infra\Extension\Label;

use Jfsimon\Datagrid\Infra\Extension\LabelExtension;
use Jfsimon\Datagrid\Infra\Formatter\LabelFormatter;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Cell;
use Jfsimon\Datagrid\Model\Data\Entity;
use Jfsimon\Datagrid\Service\HandlerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class LabelHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            LabelExtension::NAME                  => true,
            LabelExtension::NAME.'_trans'         => false,
            LabelExtension::NAME.'_trans_domain'  => 'datagrid',
            LabelExtension::NAME.'_trans_pattern' => '{grid}.{column}.'.LabelExtension::NAME,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Column $column, Entity $entity = null, array $options = array())
    {
        if ($options[LabelExtension::NAME.'_trans']) {
            $cell = new Cell(strtr($options[LabelExtension::NAME.'_trans_pattern'], array(
                '{grid}'   => $column->getGrid()->getName(),
                '{column}' => $column->getName(),
            )));
            $cell->vars['trans_enabled'] = true;
            $cell->vars['trans_domain'] = $options[LabelExtension::NAME.'_trans_domain'];
        } else {
            $formatter = new LabelFormatter();
            $cell = new Cell($formatter->format($column->getName()));
        }

        return $cell;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return LabelExtension::NAME;
    }
}
