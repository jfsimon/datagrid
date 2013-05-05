<?php

namespace Jfsimon\Datagrid\Infra\Handler;

use Jfsimon\Datagrid\Infra\Extension\DataExtension;
use Jfsimon\Datagrid\Infra\Extension\LabelExtension;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Cell;
use Jfsimon\Datagrid\Model\Data\Entity;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class LabelActionsHandler extends AbstractActionsHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(Column $column, Entity $entity = null, array $options = array())
    {
        return new Cell($this->getContent($this->getActions($options)->getGlobalActions(), $column, $options));
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return LabelExtension::NAME;
    }
}
