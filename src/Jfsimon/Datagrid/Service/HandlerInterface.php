<?php

namespace Jfsimon\Datagrid\Service;

use Jfsimon\Datagrid\Model\Component\Cell\CellInterface;
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
     * Returns true if supports given data.
     *
     * @param mixed $data
     *
     * @return boolean
     */
    public function supports($data);

    /**
     * Generates a cell with given data & options.
     *
     * @param mixed  $data    The data row
     * @param string $name    The column name
     * @param array  $options
     *
     * @return CellInterface
     */
    public function handle($data, $name, array $options);

    /**
     * Returns supported row type.
     *
     * @return string
     */
    public function getType();
}
