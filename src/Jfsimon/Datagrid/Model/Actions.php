<?php

namespace Jfsimon\Datagrid\Model;

use Jfsimon\Datagrid\Model\Data\Entity;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Actions
{
    /**
     * @var boolean
     */
    private $enabled;

    /**
     * @var array
     */
    private $globalActions = array();

    /**
     * @var array
     */
    private $entityActions = array();

    /**
     * @return Actions
     */
    public static function enable()
    {
        return new self(true);
    }

    /**
     * @return Actions
     */
    public static function disable()
    {
        return new self(false);
    }

    /**
     * @param boolean $enabled
     */
    public function __construct($enabled)
    {
        $this->enabled = (boolean) $enabled;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Adds a global action URL.
     *
     * @param string $name
     * @param string $url
     *
     * @return Actions
     */
    public function addGlobalUrl($name, $url)
    {
        $this->globalActions[] = array(
            'router' => false,
            'name'   => $name,
            'url'    => $url,
        );

        return $this;
    }

    /**
     * Adds a global action route.
     *
     * @param string $name
     * @param string $route
     * @param array  $parameters
     *
     * @return Actions
     */
    public function addGlobalRoute($name, $route, array $parameters = array())
    {
        $this->globalActions[] = array(
            'router'     => true,
            'name'       => $name,
            'route'      => $route,
            'parameters' => $parameters,
        );

        return $this;
    }

    /**
     * Adds an entity action URL.
     *
     * @param string $name
     * @param string $pattern
     *
     * @return Actions
     */
    public function addEntityUrl($name, $pattern)
    {
        $this->entityActions[] = array(
            'router'  => false,
            'name'    => $name,
            'pattern' => $pattern,
        );

        return $this;
    }

    /**
     * Adds an entity action route.
     *
     * @param string $name
     * @param string $route
     * @param array  $mapping
     * @param array  $parameters
     *
     * @return Actions
     */
    public function addEntityRoute($name, $route, array $mapping, array $parameters = array())
    {
        $this->entityActions[] = array(
            'router'     => true,
            'name'       => $name,
            'route'      => $route,
            'mapping'    => $mapping,
            'parameters' => $parameters,
        );

        return $this;
    }

    /**
     * Returns global actions.
     *
     * @return array
     */
    public function getGlobalActions()
    {
        return $this->globalActions;
    }

    /**
     * Returns actions according to given entity.
     *
     * @param Entity $entity
     *
     * @return array
     */
    public function resolveEntityActions(Entity $entity)
    {
        $actions = array();

        foreach ($this->entityActions as $action) {
            $actions[] = $action['router'] ? array(
                'router'     => true,
                'name'       => $action['name'],
                'route'      => $action['route'],
                'parameters' => $this->resolveEntityParameters($action['mapping'], $entity),
            ) : array(
                'router' => false,
                'name'   => $action['name'],
                'url'    => $this->resolveEntityUrl($action['pattern'], $entity),
            );
        }

        return $actions;
    }

    /**
     * Builds route parameters with entity properties value using mapping.
     *
     * @param array  $mapping
     * @param Entity $entity
     *
     * @return array
     */
    private function resolveEntityParameters(array $mapping, Entity $entity)
    {
        $parameters = array();

        foreach ($mapping as $parameter => $property) {
            $parameters[$parameter] = $entity->get($property);
        }

        return $parameters;
    }

    /**
     * Substitute URL placeholders with entity properties value.
     *
     * @param string $pattern
     * @param Entity $entity
     *
     * @return string
     */
    private function resolveEntityUrl($pattern, Entity $entity)
    {
        return preg_replace_callback('~\\{([\w]+)\\}~', function (array $matches) use ($entity) {
            return $entity->get($matches[1]);
        }, $pattern);
    }
}
