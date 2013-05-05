<?php

namespace Jfsimon\Datagrid\Model\Component;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Collection extends AbstractComponent implements ContentInterface
{
    /**
     * @param array ComponentInterface[]
     */
    public function __construct(array $items = array())
    {
        parent::__construct();
        $this->name = 'collection';
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * Adds an item to the collection.
     *
     * @param ComponentInterface $item
     */
    public function add(ComponentInterface $item)
    {
        $this->children[] = $item;
    }

    /**
     * Returns renderer template names.
     *
     * @return array
     */
    protected function getRendererTemplates()
    {
        return array('collection');
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
        return array('collection' => $this->children);
    }
}
