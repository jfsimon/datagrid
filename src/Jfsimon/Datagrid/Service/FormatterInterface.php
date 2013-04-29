<?php

namespace Jfsimon\Datagrid\Service;

use Jfsimon\Datagrid\Exception\FormatterException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface FormatterInterface
{
    /**
     * Configures column's options resolver.
     *
     * @param OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver);

    /**
     * Formats given value.
     *
     * @param mixed $value
     * @param array $options
     *
     * @throws FormatterException
     *
     * @return string
     */
    public function format($value, array $options = array());

    /**
     * Returns formatter name.
     *
     * @return string
     */
    public function getName();
}
