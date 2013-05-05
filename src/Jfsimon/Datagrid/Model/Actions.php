<?php

namespace Jfsimon\Datagrid\Model;

use Jfsimon\Datagrid\Model\Data\Entity;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Actions
{
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
    public static function create()
    {
        return new self();
    }

    /**
     * Adds a global action.
     *
     * @param string $name
     * @param string $url
     *
     * @return Actions
     */
    public function addGlobalAction($name, $url)
    {
        $this->globalActions[] = array(
            'name' => $name,
            'url'  => $url,
        );

        return $this;
    }

    /**
     * Adds an entity action.
     *
     * @param string $name
     * @param string $pattern
     *
     * @return Actions
     */
    public function addEntityAction($name, $pattern)
    {
        $this->entityActions[] = array(
            'name'    => $name,
            'pattern' => $pattern,
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
            $actions[] = array(
                'name' => $action['name'],
                'url'  => $this->resolveEntityUrl($action['pattern'], $entity),
            );
        }

        return $actions;
    }

    /**
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
