<?php

namespace Jfsimon\Datagrid\Model;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Trans
{
    private $enabled;
    private $pattern;
    private $domain;

    /**
     * @param string $pattern
     * @param string $domain
     *
     * @return Trans
     */
    public static function enable($pattern = '{grid}.{extension}.{subject}', $domain = 'datagrid')
    {
        return new self(true, $pattern, $domain);
    }

    /**
     * @param string $pattern
     * @param string $domain
     *
     * @return Trans
     */
    public static function disable($pattern = '{grid}.{extension}.{subject}', $domain = 'datagrid')
    {
        return new self(false, $pattern, $domain);
    }

    /**
     * @param boolean $enabled
     * @param string  $pattern
     * @param string  $domain
     */
    public function __construct($enabled, $pattern, $domain)
    {
        $this->enabled = (boolean) $enabled;
        $this->pattern = $pattern;
        $this->domain = $domain;
    }

    /**
     * @param string
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param array $replacements
     *
     * @return string
     */
    public function resolvePattern(array $replacements)
    {
        return strtr($this->pattern, $replacements);
    }
}
