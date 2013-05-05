<?php

namespace Jfsimon\Datagrid\Model\Component;

use Jfsimon\Datagrid\Model\Component\AbstractComponent;
use Jfsimon\Datagrid\Model\Component\Row;

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
     * @param ContentInterface|null $content
     */
    public function __construct(ContentInterface $content = null)
    {
        parent::__construct();
        $this->children['content'] = $content;
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
     * @param ContentInterface $content
     *
     * @return Cell
     */
    public function setContent(ContentInterface $content = null)
    {
        $this->children['content'] = $content;

        return $this;
    }

    /**
     * @return ContentInterface
     */
    public function getContent()
    {
        return $this->children['content'];
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
        $name = $this->children['content'] ? $this->children['content']->getName().'Cell' : 'cell';

        return array(
            $this->row->getSection()->getGrid()->getName().ucfirst($this->row->getSection()->getName()).ucfirst($this->row->getName()).ucfirst($name),
            $this->row->getSection()->getName().ucfirst($this->row->getName()).ucfirst($name),
            $this->row->getName().ucfirst($name),
            $name,
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getRendererContext(array $options)
    {
        if (null === $content = $this->children['content']) {
            return array();
        }

        return array(
            $content->getName() => $content,
        );
    }
}
