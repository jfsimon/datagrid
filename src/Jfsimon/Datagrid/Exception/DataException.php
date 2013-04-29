<?php

namespace Jfsimon\Datagrid\Exception;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DataException extends AbstractException
{
    /**
     * Invalid collection data.
     *
     * @param mixed $data
     *
     * @return DataException
     */
    public static function invalidCollectionData($data)
    {
        return new self(sprintf(
            'Invalid collection data: "%s" given, but array or \Traversable instance expected.',
            self::getType($data)
        ));
    }

    /**
     * Invalid entity data.
     *
     * @param mixed $data
     *
     * @return DataException
     */
    public static function invalidEntityData($data)
    {
        return new self(sprintf(
            'Invalid entity data: "%s" given, but array or object instance expected.',
            self::getType($data)
        ));
    }
}
