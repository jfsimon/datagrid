<?php

namespace Jfsimon\Datagrid\Model\Component;

/**
 * Section component compound with rows.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Section extends AbstractComponent
{
    /**
     * @var null|Grid
     */
    private $grid;

    /**
     * Constructor.
     *
     * @param Row[] $rows
     */
    public function __construct(array $rows = array())
    {
        parent::__construct();
        foreach ($rows as $name => $row) {
            $this->add($name, $row);
        }
    }

    /**
     * Adds a row.
     *
     * @param string $name
     * @param Row    $row
     *
     * @return Section
     */
    public function add($name, Row $row)
    {
        $this->children[$name] = $row->bind($this, $name);

        return $this;
    }

    /**
     * Binds the section to a grid.
     *
     * @param Grid   $grid
     * @param string $name
     *
     * @return Section
     */
    public function bind(Grid $grid, $name)
    {
        $this->grid = $grid;
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRendererTemplates()
    {
        return array($this->grid->getName().'Grid'.ucfirst($this->name), $this->name.'Section', 'section');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRendererContext(array $options)
    {
        return array('rows' => $this->children);
    }
}
