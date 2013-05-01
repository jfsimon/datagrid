<?php

namespace Jfsimon\Datagrid\Model\Component\Cell;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class LabelCell extends AbstractCell
{
    /**
     * @var string
     */
    private $label;

    /**
     * @param string $label
     */
    public function __construct($label)
    {
        $this->label = $label;
    }

    /**
     * @param string $label
     *
     * @return LabelCell
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    protected function getRendererTemplateName()
    {
        return 'labelCell';
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
        return array('label' => $this->label);
    }
}
