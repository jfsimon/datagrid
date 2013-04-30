<?php

namespace Jfsimon\Datagrid\Service;

use Jfsimon\Datagrid\Exception\ConfigurationException;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Data\Collection;

/**
 * Grid factory service interface.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface FactoryInterface
{
    /**
     * Registers an extension.
     *
     * @param ExtensionInterface $extension
     * @param int                $priority
     *
     * @return FactoryInterface
     */
    public function register(ExtensionInterface $extension, $priority = 0);

    /**
     * Creates a column for given type & options.
     *
     * @param string $type
     * @param array  $globalOptions
     * @param array  $columnOptions
     *
     * @return Column
     */
    public function createColumn($type, array $globalOptions = array(), array $columnOptions = array());

    /**
     * Creates a grid for given data collection & options.
     *
     * Valid options are:
     * * schema: the schema used to setup the grid
     *
     * @param Collection $collection
     * @param array      $options
     *
     * @throws ConfigurationException if schema not found or guessed
     *
     * @return Grid
     */
    public function createGrid(Collection $collection, array $options = array());
}
