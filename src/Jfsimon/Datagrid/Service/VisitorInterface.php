<?php

namespace Jfsimon\Datagrid\Service;

use Jfsimon\Datagrid\Model\Component\ComponentInterface;

/**
 * Components visitor service interface.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface VisitorInterface
{
    /**
     * Enters visited component.
     *
     * @param ComponentInterface $component
     *
     * @return boolean Object is visited if true
     */
    public function enter(ComponentInterface $component);

    /**
     * Leaves visited component
     *
     * Action is taken given the method result:
     * * true:   object is kept
     * * false:  object is removed
     * * object: object is replaced by the returned one
     *
     * @param ComponentInterface $component
     *
     * @return ComponentInterface|boolean
     */
    public function leave(ComponentInterface $component);
}
