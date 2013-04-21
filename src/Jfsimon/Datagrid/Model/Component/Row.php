<?php

namespace Jfsimon\Datagrid\Model\Component;

use Jfsimon\Datagrid\Model\Component\Cell\CellInterface;

/**
 * Section component compound with rows.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Row extends AbstractComponent
{
    /**
     * @var null|Section
     */
    private $section;

    /**
     * @var string
     */
    private $type;

    /**
     * Constructor.
     *
     * @param string          $type
     * @param CellInterface[] $cells
     */
    public function __construct($type, array $cells = array())
    {
        parent::__construct();
        $this->type = $type;
        foreach ($cells as $name => $cell) {
            $this->add($name, $cell);
        }
    }

    /**
     * Adds a cell.
     *
     * @param string        $name
     * @param CellInterface $cell
     *
     * @return Section
     */
    public function add($name, CellInterface $cell)
    {
        $this->children[$name] = $cell->bind($this, $name);

        return $this;
    }

    /**
     * Binds the row to a section.
     *
     * @param Section $section
     * @param string  $name
     *
     * @return Section
     */
    public function bind(Section $section, $name)
    {
        $this->section = $section;
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Section|null
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRendererTemplates()
    {
        return array($this->section->getName().ucfirst($this->type).'Row', $this->type.'Row', 'row');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRendererContext(array $options)
    {
        return array('cells' => $this->children);
    }
}
