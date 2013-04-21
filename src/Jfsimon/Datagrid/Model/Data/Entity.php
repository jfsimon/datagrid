<?php

namespace Jfsimon\Datagrid\Model\Data;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Data entity.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Entity
{
    /**
     * @var array|object
     */
    private $data;

    /**
     * @var PropertyAccessorInterface
     */
    private $accessor;

    /**
     * @var array
     */
    private $mapping;

    /**
     * Constructor.
     *
     * @param array|object              $data
     * @param PropertyAccessorInterface $accessor
     * @param array                     $mapping
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($data, PropertyAccessorInterface $accessor, array $mapping = array())
    {
        if (!is_array($data) && !is_object($data)) {
           throw new \InvalidArgumentException('Entity data must be array or object.');
        }

        $this->data = $data;
        $this->accessor = $accessor;
        $this->mapping = $mapping;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        $path = isset($this->mapping[$name]) ? $this->mapping[$name] : $name;

        return $this->accessor->getValue($this->data, $path);
    }

    /**
     * @return array|object
     */
    public function getRaw()
    {
        return $this->data;
    }
}
