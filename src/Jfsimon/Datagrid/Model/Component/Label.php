<?php

namespace Jfsimon\Datagrid\Model\Component;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Label extends AbstractComponent implements ContentInterface
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var boolean
     */
    private $trans;

    /**
     * @var string
     */
    private $domain;

    /**
     * @param string $text
     * @param bool   $trans
     * @param string $domain
     */
    public function __construct($text, $trans = false, $domain = 'datagrid')
    {
        parent::__construct();
        $this->name = 'label';
        $this->text = $text;
        $this->trans = $trans;
        $this->domain = $domain;
    }

    /**
     * Returns renderer template names.
     *
     * @return array
     */
    protected function getRendererTemplates()
    {
        return array('label');
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
            'text'   => $this->text,
            'trans'  => $this->trans,
            'domain' => $this->domain,
        );
    }
}
