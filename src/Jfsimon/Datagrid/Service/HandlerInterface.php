<?php

namespace Jfsimon\Datagrid\Service;

use Jfsimon\Datagrid\Model\Component\Cell\CellInterface;
use Jfsimon\Datagrid\Model\Data\Entity;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Data handler service interface.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface HandlerInterface
{
    /**
     * Configures column's options resolver.
     *
     * @param OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver);

    /**
     * Generates a cell with given entity, column name & options.
     *
     * @param Entity $entity
     * @param string $name
     * @param array  $options
     *
     * @return CellInterface
     */
    public function handle(Entity $entity, $name, array $options);

    /**
     * Returns supported row type.
     *
     * @return string
     */
    public function getType();
}
