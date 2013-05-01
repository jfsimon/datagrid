<?php

namespace Jfsimon\Datagrid\Model\Component\Cell;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DataCell extends AbstractCell
{
    /**
     * @var string
     */
    private $content;

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @param string $content
     *
     * @return DataCell
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    protected function getRendererTemplateName()
    {
        return 'dataCell';
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
        return array('content' => $this->content);
    }
}
