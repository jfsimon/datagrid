<?php

namespace Jfsimon\Datagrid\Exception;

use Jfsimon\Datagrid\Service\FormatterInterface;

/**
 * Formatter exception.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class FormatterException extends AbstractException
{
    /**
     * Named formatter not found.
     *
     * @param string $name
     * @param array  $validNames
     *
     * @return FormatterException
     */
    public static function notFound($name, array $validNames)
    {
        return new self(sprintf(
            'Formatter "%s" no found, registered ones are "%s".',
            $name, implode('", "', $validNames)
        ));
    }

    /**
     * Intl formatting error.
     *
     * @param FormatterInterface $formatter
     * @param string             $message
     *
     * @return FormatterException
     */
    public static function intlError(FormatterInterface $formatter, $message)
    {
        return new self(sprintf(
            '[Intl error with "%s" formatter]: %s.',
            $formatter->getName(), $message
        ));
    }

    /**
     * Invalid data type.
     *
     * @param FormatterInterface $formatter
     * @param mixed              $value
     * @param string             $expectedType
     *
     * @return FormatterException
     */
    public static function invalidType(FormatterInterface $formatter, $value, $expectedType)
    {
        return new self(sprintf(
            'Invalid data type for "%s" formatter: "%s" given, but %s expected.',
            $formatter->getName(), self::getType($value), $expectedType
        ));
    }
}
