<?php

namespace Jfsimon\Datagrid\Model\Component;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Cell extends AbstractComponent
{
    /**
     * @var null|Row
     */
    private $row;

    /**
     * @var string
     */
    private $content;

    /**
     * @var boolean
     */
    private $heading;

    /**
     * Constructor.
     *
     * @param string $content
     * @param bool   $heading
     */
    public function __construct($content = '', $heading = false)
    {
        $this->content = $content;
        $this->heading = $heading;
    }

    /**
     * {@inheritdoc}
     */
    public function bind(Row $row, $name)
    {
        $this->row = $row;
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $content
     *
     * @return Cell
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
     * @param boolean $heading
     *
     * @return Cell
     */
    public function setHeading($heading)
    {
        $this->heading = (bool) $heading;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHeading()
    {
        return $this->heading;
    }

    /**
     * @return Row|null
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRendererTemplates()
    {
        return array(ucfirst($this->row->getName()).'Cell', 'cell');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRendererContext(array $options)
    {
        return array(
            'content' => $this->content,
            'heading' => $this->heading,
        );
    }
}
