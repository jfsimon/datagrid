<?php

namespace Jfsimon\Datagrid\Model\Event;

use Jfsimon\Datagrid\Model\Component\Grid;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class GridEvent extends Event
{
    /**
     * @var Grid
     */
    private $grid;

    /**
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * @param Grid $grid
     *
     * @return GridEvent
     */
    public function setGrid(Grid $grid)
    {
        $this->grid = $grid;

        return $this;
    }

    /**
     * @return Grid
     */
    public function getGrid()
    {
        return $this->grid;
    }
}
