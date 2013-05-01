<?php

namespace Jfsimon\Datagrid\Model\Component\Cell;

use Jfsimon\Datagrid\Model\Component\ComponentInterface;
use Jfsimon\Datagrid\Model\Component\Row;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface CellInterface extends ComponentInterface
{
    /**
     * Binds cell to a row.
     *
     * @param Row    $row
     * @param string $name
     *
     * @return CellInterface
     */
    public function bind(Row $row, $name);
}
