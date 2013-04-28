<?php

namespace Jfsimon\Datagrid\Infra\Handler;

use Jfsimon\Datagrid\Infra\Extension\DataExtension;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Cell;
use Jfsimon\Datagrid\Model\Data\Entity;
use Jfsimon\Datagrid\Service\HandlerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ActionsHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Column $column, Entity $entity = null, array $options = array())
    {
        // todo: implement this method
        return new Cell();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return DataExtension::NAME;
    }
}
