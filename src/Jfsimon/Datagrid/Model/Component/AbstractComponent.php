<?php

namespace Jfsimon\Datagrid\Model\Component;

use Jfsimon\Datagrid\Service\RendererInterface;
use Jfsimon\Datagrid\Service\VisitorInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractComponent implements ComponentInterface
{
    /**
     * @var array
     */
    public $vars = array();

    /**
     * @var Attributes
     */
    public $attributes;

    /**
     * @var ComponentInterface[]
     */
    protected $children = array();

    /**
     * @var null|string
     */
    protected $name;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->attributes = new Attributes();
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function accept(VisitorInterface $visitor)
    {
        if (!$visitor->enter($this)) {
            return true;
        }

        foreach ($this->children as $id => $child) {
            $result = $child->accept($visitor);

            if (false === $result) {
                $this->removeChild($id);
            }

            if ($result instanceof ComponentInterface) {
                $this->replaceChild($id, $result);
            }
        }

        return $visitor->leave($this);
    }

    /**
     * {@inheritdoc}
     */
    public function render(RendererInterface $renderer, array $options = array())
    {
        if (null === $this->name) {
            throw new \LogicException('Component must be bound before rendering.');
        }

        $templates = isset($options['template']) ? array($options['template']) : $this->getRendererTemplates();
        unset($options['template']);

        $context = array_merge(
            $this->getRendererContext(array_replace($this->getDefaultOptions(), $options)),
            array('name' => $this->name, 'attributes' => $this->attributes, 'options' => $options),
            $this->vars
        );

        return $renderer->render($templates, $context, $options);
    }

    /**
     * Removes a child component.
     *
     * @param string|int $id
     */
    protected function removeChild($id)
    {
        unset($this->children[$id]);
    }

    /**
     * Replaces a child component.
     *
     * @param string|int         $id
     * @param ComponentInterface $child
     */
    protected function replaceChild($id, ComponentInterface $child)
    {
        $this->children[$id] = $child;
    }

    /**
     * Returns renderer template names.
     *
     * @return array
     */
    abstract protected function getRendererTemplates();

    /**
     * Returns renderer context.
     *
     * @param array $options
     *
     * @return array
     */
    abstract protected function getRendererContext(array $options);

    /**
     * Returns default options.
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array();
    }
}
