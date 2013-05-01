<?php

namespace Jfsimon\Datagrid\Infra\Handler;

use Jfsimon\Datagrid\Infra\Extension\DataExtension;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Cell\ActionsCell;
use Jfsimon\Datagrid\Model\Data\Entity;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DataActionsHandler extends AbstractActionsHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(Column $column, Entity $entity = null, array $options = array())
    {
        return new ActionsCell($this->getActions($options)->resolveEntityActions($entity));
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return DataExtension::NAME;
    }
}
