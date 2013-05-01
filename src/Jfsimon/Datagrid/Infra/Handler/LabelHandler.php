<?php

namespace Jfsimon\Datagrid\Infra\Handler;

use Jfsimon\Datagrid\Infra\Extension\LabelExtension;
use Jfsimon\Datagrid\Infra\Formatter\LabelFormatter;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Cell\EmptyCell;
use Jfsimon\Datagrid\Model\Component\Cell\LabelCell;
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
        // translator enabled
        if ($options[LabelExtension::NAME.'_trans']) {
            $cell = new LabelCell(strtr($options[LabelExtension::NAME.'_trans_pattern'], array(
                '{grid}'   => $column->getGrid()->getName(),
                '{column}' => $column->getName(),
            )));

            $cell->vars['trans_enabled'] = true;
            $cell->vars['trans_domain'] = $options[LabelExtension::NAME.'_trans_domain'];

            return $cell;
        }

        // custom label
        if (is_string($options[LabelExtension::NAME])) {
            return new LabelCell($options[LabelExtension::NAME]);
        }

        // label enabled
        if ($options[LabelExtension::NAME]) {
            $formatter = new LabelFormatter();

            return new LabelCell($formatter->format($column->getName()));
        }

        return new EmptyCell();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return LabelExtension::NAME;
    }
}
