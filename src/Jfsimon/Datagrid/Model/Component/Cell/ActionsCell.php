<?php

namespace Jfsimon\Datagrid\Model\Component\Cell;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ActionsCell extends AbstractCell
{
    /**
     * @var array
     */
    private $actions;

    /**
     * @param array $actions
     */
    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    /**
     * @param array $actions
     *
     * @return ActionsCell
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @return string
     */
    protected function getRendererTemplateName()
    {
        return 'actionsCell';
    }

    /**
     * Returns renderer context.
     *
     * @param array $options
     *
     * @return array
     */
    protected function getRendererContext(array $options)
    {
        return array('actions' => $this->actions);
    }
}
