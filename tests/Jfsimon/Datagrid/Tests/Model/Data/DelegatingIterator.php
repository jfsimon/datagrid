<?php

namespace Jfsimon\Datagrid\Tests\Model\Data;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DelegatingIterator implements \IteratorAggregate
{
    private $iterator;

    public function __construct(\Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    public function getIterator()
    {
        return $this->iterator;
    }
}
