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
     * @param null|Section $head
     * @param null|Section $body
     * @param null|Section $foot
     * @param string       $name
     * @param null|string  $caption
     */
    public function __construct(Section $head = null, Section $body = null, Section $foot = null, $name = 'default', $caption = null)
    {
        parent::__construct();

        $head = $head ?: new Section();
        $body = $body ?: new Section();
        $foot = $foot ?: new Section();

        $this->children = array(
            'head' => $head->bind($this, 'head'),
            'body' => $body->bind($this, 'body'),
            'foot' => $foot->bind($this, 'foot'),
        );

        $this->name = $name;
        $this->caption = $caption;
        $this->columns = array();
    }

    /**
     * @return Section
     */
    public function getHead()
    {
        return $this->children['head'];
    }

    /**
     * @return Section
     */
    public function getBody()
    {
        return $this->children['body'];
    }

    /**
     * @return Section
     */
    public function getFoot()
    {
        return $this->children['foot'];
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
            'head'    => $options['head'] ? $this->children['head'] : null,
            'body'    => $this->children['body'],
            'foot'    => $options['foot'] ? $this->children['foot'] : null,
            'caption' => $options['caption'] ? $this->caption : null,
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultOptions()
    {
        return array(
            'head'     => true,
            'foot'     => true,
            'caption'  => true,
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function removeChild($id)
    {
        $emptySection = new Section();
        $emptySection->bind($this, $id);
        $this->children[$id] = $emptySection;
    }
}
