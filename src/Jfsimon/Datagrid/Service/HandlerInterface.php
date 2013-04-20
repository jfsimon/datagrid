<?php

namespace Jfsimon\Datagrid\Service;

use Jfsimon\Datagrid\Model\Component\Cell\CellInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
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
     * @param mixed $data
     * @param array $options
     *
     * @return CellInterface
     */
    public function handle($data, array $options);

    /**
     * Returns supported row type.
     *
     * @return string
     */
    public function getType();
}
