<?php

namespace Jfsimon\Datagrid\Infra\Extension\Data\Formatter;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class StringFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'null_value' => '',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function format($value, array $options = array())
    {
        if (null === $value) {
            return $options['null_value'];
        }

        return (string) $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'string';
    }
}
