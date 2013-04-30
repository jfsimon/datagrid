<?php

namespace Jfsimon\Datagrid\Bridge\Twig\Extension;

use Jfsimon\Datagrid\Infra\Renderer\TwigRenderer;
use Jfsimon\Datagrid\Model\Component\ComponentInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DatagridExtension extends \Twig_Extension
{
    /**
     * @var TwigRenderer
     */
    private $renderer;

    /**
     * @param TwigRenderer $renderer
     */
    public function __construct(TwigRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->renderer->setTwigEnvironment($environment);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'datagrid' => new \Twig_Function_Method($this, 'renderComponent', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders a datagrid component.
     *
     * @param ComponentInterface $component
     * @param array              $options
     *
     * @return string
     */
    public function renderComponent(ComponentInterface $component, array $options = array())
    {
        return $component->render($this->renderer, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'datagrid';
    }
}
