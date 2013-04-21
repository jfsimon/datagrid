<?php

namespace Jfsimon\Datagrid\Service;

/**
 * Component renderer service interface.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface RendererInterface
{
    /**
     * Renders a grid component.
     *
     * Common options are:
     * * template: string, path to the skin template
     *
     * @param array $templates
     * @param array $context
     * @param array $options
     *
     * @return string
     */
    public function render(array $templates, array $context,  array $options = array());
}
