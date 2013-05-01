<?php

namespace Jfsimon\Datagrid\Infra\Handler;

use Jfsimon\Datagrid\Infra\Extension\DataExtension;
use Jfsimon\Datagrid\Infra\Extension\LabelExtension;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Cell\ActionsCell;
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
        return new ActionsCell($this->getActions($options)->getGlobalActions());
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return LabelExtension::NAME;
    }
}
