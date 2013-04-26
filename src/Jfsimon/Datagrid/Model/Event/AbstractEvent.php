<?php

namespace Jfsimon\Datagrid\Model\Event;

use Jfsimon\Datagrid\Model\Component\Grid;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class AbstractEvent extends Event
{
    /**
     * @var Grid
     */
    private $grid;

    /**
     * @param Grid $grid
     */
    function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * @return Grid
     */
    public function getGrid()
    {
        return $this->grid;
    }
}
