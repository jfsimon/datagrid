<?php

namespace Jfsimon\Datagrid\Exception;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class AbstractException extends \Exception implements ExceptionInterface
{
    /**
     * Constructor.
     *
     * @param string          $message
     * @param \Exception|null $previous
     */
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    /**
     * Returns value type name.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected static function getType($value)
    {
        return is_object($value) ? get_class($value) : gettype($value);
    }
}
