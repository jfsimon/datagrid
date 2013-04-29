<?php

namespace Jfsimon\Datagrid\Infra\Extension;

use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Data\Entity;
use Jfsimon\Datagrid\Model\Schema;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Core extension.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class CoreExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'schema'  => null,
            'name'    => 'datagrid',
            'caption' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function guessSchema(Entity $entity, array $options)
    {
        return isset($options['schema']) ? $options['schema'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function buildGrid(Grid $grid, Schema $schema, Collection $collection, array $options = array())
    {
        $grid
            ->setName($options['name'])
            ->setCaption($options['caption'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'core';
    }
}
