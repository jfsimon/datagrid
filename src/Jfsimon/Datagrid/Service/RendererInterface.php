<?php

namespace Jfsimon\Datagrid\Service;

use Jfsimon\Datagrid\Exception\TemplateException;

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
     * Renderer tries to render templates in given order.
     * If a template is not found, the next will be tried.
     * This permits to override generic template for specific component.
     *
     * @param array $templates
     * @param array $context
     * @param array $options
     *
     * @throws TemplateException if template not found
     *
     * @return string
     */
    public function render(array $templates, array $context, array $options = array());
}
