<?php

namespace Jfsimon\Datagrid\Infra\Formatter;

use Jfsimon\Datagrid\Service\FormatterInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class NumberFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'null_value'    => '',
            'precision'     => null,
            'rounding_mode' => null,
            'grouping'      => null,
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

        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('Value mus be numeric.');
        }

        $formatter = new \NumberFormatter(\Locale::getDefault(), \NumberFormatter::DECIMAL);

        if (null !== $options['precision']) {
            $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, $options['precision']);
            $formatter->setAttribute(\NumberFormatter::ROUNDING_MODE, $options['rounding_mode']);
        }

        $formatter->setAttribute(\NumberFormatter::GROUPING_USED, $options['grouping']);

        $value = $formatter->format($value);

        if (intl_is_failure($formatter->getErrorCode())) {
            throw new \RuntimeException($formatter->getErrorMessage());
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'number';
    }
}
