<?php

namespace Jfsimon\Datagrid\Infra\Formatter;

use Jfsimon\Datagrid\Service\FormatterInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class LabelFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function format($value, array $options = array())
    {
        return ucfirst(strtolower(str_replace('_', ' ', preg_replace('~(?<=\\w)([A-Z])~', ' $1', $value))));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'string';
    }
}
