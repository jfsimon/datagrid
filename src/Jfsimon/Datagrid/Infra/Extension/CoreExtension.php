<?php

namespace Jfsimon\Datagrid\Infra\Extension;

use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Component\Row;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Data\Entity;
use Jfsimon\Datagrid\Model\Schema;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class CoreExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setAllowedTypes(array(
            'schema' => 'Jfsimon\Datagrid\Model\Schema',
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
    public function buildGrid(Grid $grid, Collection $collection, array $options = array())
    {
        $schema = $options['schema'];
        if (!$schema instanceof Schema) {
            throw new \InvalidArgumentException('Schema option must be an instance of Schema.');
        }

        $index = 0;
        while ($entity = $collection->next()) {
            $schema->build($row = new Row('data'), $entity);
            $grid->getBody()->add($entity->getId() ?: $index ++, $row);
        };

        return $grid;
    }
}
