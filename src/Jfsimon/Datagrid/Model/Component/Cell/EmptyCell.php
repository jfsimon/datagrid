<?php

namespace Jfsimon\Datagrid\Model\Component\Cell;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class EmptyCell extends AbstractCell
{
    /**
     * @return string
     */
    protected function getRendererTemplateName()
    {
        return 'emptyCell';
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
        return array();
    }
}
