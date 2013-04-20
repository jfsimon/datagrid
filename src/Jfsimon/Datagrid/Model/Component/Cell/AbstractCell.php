<?php

namespace Jfsimon\Datagrid\Model\Component\Cell;

use Jfsimon\Datagrid\Model\Component\AbstractComponent;
use Jfsimon\Datagrid\Model\Component\Row;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class AbstractCell extends AbstractComponent implements CellInterface
{
    /**
     * @var null|Row
     */
    protected $row;

    /**
     * {@inheritdoc}
     */
    public function bind(Row $row, $name)
    {
        $this->row = $row;
        $this->name = $name;

        return $this;
    }
}
