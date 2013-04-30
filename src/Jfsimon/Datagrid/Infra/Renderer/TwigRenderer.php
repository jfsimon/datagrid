<?php

namespace Jfsimon\Datagrid\Infra\Renderer;

use Jfsimon\Datagrid\Exception\TemplateException;
use Jfsimon\Datagrid\Exception\WorkflowException;
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
     * @param string $defaultTemplate
     */
    public function __construct($defaultTemplate)
    {
        $this->defaultTemplate = $defaultTemplate;
    }

    /**
     * Registers the Twig environment.
     *
     * @param \Twig_Environment $twigEnvironment
     *
     * @return TwigRenderer
     */
    public function setTwigEnvironment(\Twig_Environment $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;

        return $this;
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
     * @throws WorkflowException
     * @throws TemplateException
     */
    private function loadTemplate($template = null)
    {
        if (null === $this->twigEnvironment) {
            throw WorkflowException::twigNotDefined();
        }

        $template = $template ?: $this->defaultTemplate;

        try {
            return $this->twigEnvironment->loadTemplate($template);
        } catch (\Exception $e) {
            throw TemplateException::twigTemplateNotFound($template, $e);
        }
    }
}
