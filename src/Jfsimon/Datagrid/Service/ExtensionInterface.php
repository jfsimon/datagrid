<?php

namespace Jfsimon\Datagrid\Service;

use Jfsimon\Datagrid\Exception\FormatterException;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Data\Entity;
use Jfsimon\Datagrid\Model\Schema;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Extension service interface.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface ExtensionInterface
{
    /**
     * Configures options resolver.
     *
     * @param OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver);

    /**
     * Tries to guess schema from an entity.
     *
     * @param Entity $entity
     * @param array  $options
     *
     * @return Schema|null
     */
    public function guessSchema(Entity $entity = null, array $options);

    /**
     * Builds columns schema.
     *
     * @param Schema     $schema
     * @param Collection $collection
     * @param array      $options
     */
    public function buildSchema(Schema $schema, Collection $collection, array $options = array());

    /**
     * Builds a column.
     *
     * @param Column $column
     * @param string $type
     * @param array  $options
     *
     * @throws FormatterException if formatter not found
     */
    public function buildColumn(Column $column, $type, array $options = array());

    /**
     * Builds grid rows.
     *
     * @param Grid       $grid
     * @param Schema     $schema
     * @param Collection $collection
     * @param array      $options
     */
    public function buildGrid(Grid $grid, Schema $schema, Collection $collection, array $options = array());

    /**
     * Visits grid.
     *
     * @param Grid  $grid
     * @param array $options
     */
    public function visit(Grid $grid, array $options = array());

    /**
     * Returns extension name.
     *
     * @return string
     */
    public function getName();
}
