<?php

namespace Jfsimon\Datagrid\Service;

use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Cell;
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
     * Generates a cell with given column, optional entity & options.
     *
     * @param Column      $column
     * @param Entity|null $entity
     * @param array       $options
     *
     * @return Cell
     */
    public function handle(Column $column, Entity $entity = null, array $options = array());

    /**
     * Returns supported row type.
     *
     * @return string
     */
    public function getType();
}
