<?php

namespace Jfsimon\Datagrid\Infra\Extension\Data\Formatter;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class BooleanFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'true_value'  => 'yes',
            'false_value' => 'no',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function format($value, array $options = array())
    {
        return $value ? $options['true_value'] : $options['false_value'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'boolean';
    }
}
