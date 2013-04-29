<?php

namespace Jfsimon\Datagrid\Model\Component;

/**
 * Component HTML attributes.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Attributes
{
    /**
     * @var array
     */
    private $attributes = array();

    /**
     * @var array
     */
    private $classes = array();

    /**
     * @param string      $name
     * @param null|string $value
     *
     * @return Attributes
     */
    public function set($name, $value = null)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    public function get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * @param string $class
     *
     * @return Attributes
     */
    public function addClass($class)
    {
        $this->classes[] = $class;

        return $this;
    }

    /**
     * @param string $class
     *
     * @return Attributes
     */
    public function removeClass($class)
    {
        foreach (array_keys($this->classes, $class) as $index) {
            unset($this->classes[$index]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        $attributes = array_filter($this->attributes, function ($attr) { return (bool) $attr; });

        if (count($this->classes)) {
            $attributes['class'] = implode(' ', $this->classes);
        }

        return $attributes;
    }

    /**
     * Renders attributes as HTML string.
     *
     * @return string
     */
    public function __toString()
    {
        $html = '';
        foreach ($this->all() as $name => $value) {
            $html .= sprintf(' %s="%s"', $name, $value);
        }

        return $html;
    }
}
