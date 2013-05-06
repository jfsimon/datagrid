<?php

namespace Jfsimon\Datagrid\Model\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class OptionsEvent extends Event
{
    /**
     * @var array
     */
    private $options;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @param array $options
     *
     * @return OptionsEvent
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
