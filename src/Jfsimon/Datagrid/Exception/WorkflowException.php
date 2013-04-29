<?php

namespace Jfsimon\Datagrid\Exception;

use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\ComponentInterface;
use Jfsimon\Datagrid\Model\Schema;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class WorkflowException extends AbstractException
{
    /**
     * Component is not bound.
     *
     * @param ComponentInterface $component
     * @param string             $operation
     *
     * @return WorkflowException
     */
    public static function unboundComponent(ComponentInterface $component, $operation)
    {
        return new self(sprintf('"%s" component must be bound before %s operation.', $component->getName(), $operation));
    }
    /**
     * Schema is not bound.
     *
     * @param string $operation
     *
     * @return WorkflowException
     */
    public static function unboundSchema($operation)
    {
        return new self(sprintf('Schema must be bound before %s operation.', $operation));
    }

    /**
     * Column is configured.
     *
     * @param Column $column
     * @param string $operation
     *
     * @return WorkflowException
     */
    public static function configuredColumn(Column $column, $operation)
    {
        return new self(sprintf(
            'Column "%s" is configured and can not process %s operation.',
            $column->getName(), $operation
        ));
    }

    /**
     * Column is not configured.
     *
     * @param Column $column
     * @param string $operation
     *
     * @return WorkflowException
     */
    public static function notConfiguredColumn(Column $column, $operation)
    {
        return new self(sprintf(
            'Column "%s" is not configured and can not process %s operation.',
            $column->getName(), $operation
        ));
    }
}
