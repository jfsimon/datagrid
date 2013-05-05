<?php

namespace Jfsimon\Datagrid\Model\Component;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Url extends AbstractComponent implements ContentInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string|null
     */
    private $route;

    /**
     * @var string|null
     */
    private $parameters;

    /**
     * @param string|null $url
     * @param string|null $route
     * @param array       $parameters
     */
    public function __construct($url = null, $route = null, array $parameters = array())
    {
        parent::__construct();
        $this->name = 'url';
        $this->url = $url;
        $this->route = $route;
        $this->parameters = $parameters;
    }

    /**
     * Returns renderer template names.
     *
     * @return array
     */
    protected function getRendererTemplates()
    {
        return array('url');
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
        if (null !== $this->url) {
            return array(
                'router' => false,
                'url'    => $this->url,
            );
        }

        return array(
            'router'     => true,
            'route'      => $this->route,
            'parameters' => $this->parameters,
        );
    }
}
