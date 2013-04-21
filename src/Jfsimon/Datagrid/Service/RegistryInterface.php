<?php

namespace Jfsimon\Datagrid\Service;

use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Schema;

/**
 * Registry service interface.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface RegistryInterface
{
    /**
     * Returns a column by its name.
     *
     * @param string $name
     *
     * @return Column
     */
    public function getColumn($name);

    /**
     * Returns a schema by its name.
     *
     * @param string $name
     *
     * @return Schema
     */
    public function getSchema($name);

    /**
     * Returns a handler by its name.
     *
     * @param string $name
     *
     * @return HandlerInterface
     */
    public function getHandler($name);

    /**
     * Returns a visitor by its name.
     *
     * @param string $name
     *
     * @return VisitorInterface
     */
    public function getVisitor($name);
}
