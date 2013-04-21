<?php

namespace Jfsimon\Datagrid\Service;

use Jfsimon\Datagrid\Model\Component\Grid;

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
     * Creates a grid from data.
     *
     * @param mixed $dataset
     * @param array $options
     *
     * @return Grid
     */
    public function create($dataset, array $options = array());
}
