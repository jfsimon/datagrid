<?php

namespace Jfsimon\Datagrid\Model\Data;

use Jfsimon\Datagrid\Exception\DataException;
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
     * @var string|null
     */
    private $idPath;

    /**
     * Constructor.
     *
     * @param array|object              $data
     * @param PropertyAccessorInterface $accessor
     * @param array                     $mapping
     * @param string|null               $idPath
     *
     * @throws DataException
     */
    public function __construct($data, PropertyAccessorInterface $accessor, array $mapping = array(), $idPath = null)
    {
        if (!is_array($data) && !is_object($data)) {
           throw DataException::invalidEntityData($data);
        }

        $this->data = $data;
        $this->accessor = $accessor;
        $this->mapping = $mapping;
        $this->idPath = $idPath;
    }

    /**
     * @param string      $name
     * @param string|null $path
     *
     * @return mixed
     */
    public function get($name, $path = null)
    {
        $path = $path ?: (isset($this->mapping[$name]) ? $this->mapping[$name] : $name);

        if (is_array($this->data)) {
            $path = '['.str_replace('.', '][', $path).']';
        }

        return $this->accessor->getValue($this->data, $path);
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->idPath ? $this->get($this->idPath) : null;
    }

    /**
     * @return array|object
     */
    public function getRaw()
    {
        return $this->data;
    }
}
