<?php

namespace Jfsimon\Datagrid\Infra\Renderer;

use Jfsimon\Datagrid\Exception\TemplateException;
use Jfsimon\Datagrid\Service\RendererInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class TwigRenderer implements RendererInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twigEnvironment;

    /**
     * @var string
     */
    private $defaultTemplate;

    /**
     * Constructor.
     *
     * @param \Twig_Environment $twigEnvironment
     * @param string            $defaultTemplate
     */
    public function __construct(\Twig_Environment $twigEnvironment, $defaultTemplate)
    {
        $this->twigEnvironment = $twigEnvironment;
        $this->defaultTemplate = $defaultTemplate;
    }

    /**
     * {@inheritdoc}
     */
    public function render(array $templates, array $context, array $options = array())
    {
        $template = $this->loadTemplate(isset($options['twig_template']) ? $options['twig_template'] : null);

        foreach ($templates as $block) {
            if ($template->hasBlock($block)) {
                return $template->renderBlock($block, $context);
            }
        }

        throw TemplateException::twigBlockNotFound($templates, $template);
    }

    /**
     * @param string|null $template
     *
     * @return \Twig_Template
     *
     * @throws TemplateException
     */
    private function loadTemplate($template = null)
    {
        try {
            return $this->twigEnvironment->loadTemplate($template ?: $this->defaultTemplate);
        } catch (\Exception $e) {
            throw TemplateException::twigTemplateNotFound($template, $e);
        }
    }
}
