<?php

namespace Jfsimon\Datagrid\Model\Component;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Data extends AbstractComponent implements ContentInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        parent::__construct();
        $this->name = 'data';
        $this->value = $value;
    }

    /**
     * Returns renderer template names.
     *
     * @return array
     */
    protected function getRendererTemplates()
    {
        return array('data');
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
        return array('value' => $this->value);
    }
}
