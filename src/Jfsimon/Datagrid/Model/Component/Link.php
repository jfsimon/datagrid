<?php

namespace Jfsimon\Datagrid\Model\Component;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Link extends AbstractComponent implements ContentInterface
{
    /**
     * @param Url   $url
     * @param Label $label
     */
    public function __construct(Url $url, Label $label)
    {
        parent::__construct();
        $this->name = 'link';
        $this->children['url'] = $url;
        $this->children['label'] = $label;
    }

    /**
     * Returns renderer template names.
     *
     * @return array
     */
    protected function getRendererTemplates()
    {
        return array('link');
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
        return array(
            'url'   => $this->children['url'],
            'label' => $this->children['label'],
        );
    }
}
