<?php

namespace Jfsimon\Datagrid\Exception;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ConfigurationException extends AbstractException
{
    /**
     * Schema is neither configured or guessed.
     *
     * @param array $extensionNames
     *
     * @return ConfigurationException
     */
    public static function schemaNotFound(array $extensionNames)
    {
        return new self(sprintf(
            'Schema is not configured and could not be guessed by "%s" extensions.',
            implode('", "', $extensionNames)
        ));
    }
}
