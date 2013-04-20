<?php

namespace Jfsimon\Datagrid\Model\Component;

/**
 * Grid component compound with sections.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Grid extends AbstractComponent
{
    /**
     * @var null|string
     */
    private $caption;

    /**
     * Constructor.
     *
     * @param Section     $header
     * @param Section     $body
     * @param Section     $footer
     * @param string      $name
     * @param null|string $caption
     */
    public function __construct(Section $header, Section $body, Section $footer, $name = 'default', $caption = null)
    {
        parent::__construct();
        $this->children = array(
            'header' => $header->bind($this, 'header'),
            'body'   => $body->bind($this, 'body'),
            'footer' => $footer->bind($this, 'footer'),
        );
        $this->name = $name;
        $this->caption = $caption;
        $this->columns = array();
    }

    /**
     * {@inheritdoc}
     */
    protected function getRendererTemplates()
    {
        return array($this->name.'Grid', 'grid');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRendererContext(array $options)
    {
        return array(
            'header'  => $options['header'] ? $this->children['header'] : null,
            'body'    => $this->children['body'],
            'footer'  => $options['footer'] ? $this->children['footer'] : null,
            'caption' => $options['caption'] ? $this->caption : null,
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultOptions()
    {
        return array(
            'header'   => true,
            'footer'   => true,
            'caption'  => true,
        );
    }
}
