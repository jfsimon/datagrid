<?php

namespace Jfsimon\Datagrid\Service;

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
     *
     * @return FactoryInterface
     */
    public function register(ExtensionInterface $extension);

    /**
     * Creates a grid from data collection.
     *
     * Valid options are:
     * * schema: the schema used to setup the grid
     *
     * @param Collection $collection
     * @param array      $options
     *
     * @return Grid
     */
    public function createGrid(Collection $collection, array $options = array());

    /**
     * Creates an extension registry.
     *
     * @return RegistryInterface
     */
    public function createRegistry();
}
