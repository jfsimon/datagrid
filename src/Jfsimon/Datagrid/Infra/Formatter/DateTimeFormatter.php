<?php

namespace Jfsimon\Datagrid\Infra\Formatter;

use Jfsimon\Datagrid\Exception\FormatterException;
use Jfsimon\Datagrid\Service\FormatterInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DateTimeFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'null_value'  => '',
            'date_format' => \IntlDateFormatter::MEDIUM,
            'time_format' => \IntlDateFormatter::SHORT,
            'time_zone'   => null,
            'calendar'    => \IntlDateFormatter::GREGORIAN,
            'pattern'     => null,
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

        if (!$value instanceof \DateTime) {
            throw FormatterException::invalidType($this, $value, 'DateTime instance');
        }

        $dateTime = clone $value;

        if ('UTC' !== $options['time_zone']) {
            $dateTime->setTimezone(new \DateTimeZone('UTC'));
        }

        $formatter = new \IntlDateFormatter(\Locale::getDefault(), $options['date_format'], $options['time_format'], $options['time_zone'], $options['calendar'], $options['pattern']);
        $formatter->setLenient(false);

        $value = $formatter->format((int) $dateTime->format('U'));

        if (intl_is_failure(intl_get_error_code())) {
            throw FormatterException::intlError($this, intl_get_error_message());
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'datetime';
    }
}
