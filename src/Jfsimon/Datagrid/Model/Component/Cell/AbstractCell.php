<?php

namespace Jfsimon\Datagrid\Model\Component\Cell;

use Jfsimon\Datagrid\Model\Component\AbstractComponent;
use Jfsimon\Datagrid\Model\Component\Row;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractCell extends AbstractComponent implements CellInterface
{
    /**
     * @var null|Row
     */
    private $row;

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
        $name = $this->getRendererTemplateName();

        return array(
            $this->row->getSection()->getGrid()->getName().ucfirst($this->row->getSection()->getName()).ucfirst($this->row->getName()).ucfirst($name),
            $this->row->getSection()->getName().ucfirst($this->row->getName()).ucfirst($name),
            $this->row->getName().ucfirst($name),
            $name,
        );
    }

    abstract protected function getRendererTemplateName();
}
