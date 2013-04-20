<?php

namespace Jfsimon\Datagrid\Model\Component\Cell;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class EmptyCell extends AbstractCell
{
    /**
     * {@inheritdoc}
     */
    protected function getRendererTemplates()
    {
        return array('empty'.ucfirst($this->row->getName()).'Cell', 'emptyCell');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRendererContext(array $options)
    {
        return array();
    }
}
