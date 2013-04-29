<?php

namespace Jfsimon\Datagrid\Exception;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class TemplateException extends AbstractException
{
    /**
     * Twig template file not found.
     *
     * @param string     $file
     * @param \Exception $previous
     *
     * @return TemplateException
     */
    public static function twigTemplateNotFound($file, \Exception $previous)
    {
        return new self(sprintf('Twig template "%s" not found', $file), $previous);
    }

    /**
     * Twig block not found in template.
     *
     * @param array          $blocks
     * @param \Twig_Template $template
     *
     * @return TemplateException
     */
    public static function twigBlockNotFound(array $blocks, \Twig_Template $template)
    {
        return new self(sprintf(
            'None of "%s" twig blocks found, present ones are: "".',
            implode('", "', $blocks), implode('", "', $template->getBlockNames())
        ));
    }
}
