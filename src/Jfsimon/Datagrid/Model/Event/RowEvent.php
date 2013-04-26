<?php

namespace Jfsimon\Datagrid\Model\Event;

use Jfsimon\Datagrid\Model\Component\Row;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class RowEvent extends AbstractEvent
{
    /**
     * @var Row
     */
    private $row;

    /**
     * @param Row $row
     *
     * @return RowEvent
     */
    public function setRow($row)
    {
        $this->row = $row;

        return $this;
    }

    /**
     * @return Row
     */
    public function getRow()
    {
        return $this->row;
    }
}
