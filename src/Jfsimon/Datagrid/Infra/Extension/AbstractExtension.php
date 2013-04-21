<?php

namespace Jfsimon\Datagrid\Infra\Extension;

use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Data\Entity;
use Jfsimon\Datagrid\Model\Schema;
use Jfsimon\Datagrid\Service\ExtensionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractExtension implements ExtensionInterface
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
    public function guessSchema(Entity $entity, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildSchema(Schema $schema, Collection $collection, array $options = array())
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildGrid(Grid $grid, Collection $collection, array $options = array())
    {
    }

    /**
     * {@inheritdoc}
     */
    public function visit(Grid $grid, array $options = array())
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getColumns()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getHandlers()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getVisitors()
    {
        return array();
    }
}
