<?php

namespace Jfsimon\Datagrid\Model\Data;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Homogeneous data collection.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Collection
{
    const TYPE_ARRAY     = 1;
    const TYPE_ITERATOR  = 2;
    const TYPE_AGGREGATE = 3;

    /**
     * @var \Iterator|\IteratorIterator
     */
    private $data;

    /**
     * @var array
     */
    private $options;

    /**
     * @var PropertyAccessorInterface
     */
    private $accessor;

    /**
     * @var null|Entity
     */
    private $peek;

    /**
     * Constructor.
     *
     * Valid options are:
     * * mapping: an associative array of filed name => property path
     *
     * @param array|\Traversable $data
     * @param array              $options
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($data, array $options = array())
    {
        if (is_array($data)) {
            $this->type = self::TYPE_ARRAY;
            $this->data = new \ArrayIterator($data);
        }

        if ($data instanceof \Iterator) {
            $this->type = self::TYPE_ITERATOR;
            $this->data = $data;
        }

        if ($data instanceof \IteratorAggregate) {
            $this->type = self::TYPE_AGGREGATE;
            $this->data = new \IteratorIterator($data);
        }

        if (null === $this->type) {
            throw new \InvalidArgumentException('Collection data must be traversable or array');
        }

        $this->options = array_merge(array('mapping' => array()), $options);
        $this->accessor = PropertyAccess::getPropertyAccessor();
        $this->data->rewind();
    }

    /**
     * Returns next entity.
     *
     * @return Entity|null
     */
    public function next()
    {
        if (null !== $this->peek) {
            $entity = $this->peek;
            $this->peek = null;

            return $entity;
        }

        $item = $this->data->current();

        if (false === $item) {
            return null;
        }

        return new Entity($item, $this->accessor, $this->options['mapping']);
    }

    /**
     * Rewinds iterator.
     */
    public function rewind()
    {
        $this->data->rewind();
    }

    /**
     * Returns collection length.
     *
     * @return int
     */
    public function count()
    {
        return $this->data->count();
    }

    /**
     * Returns original data.
     *
     * @return array|\Traversable
     *
     * @throws \LogicException
     */
    public function getRaw()
    {
        switch ($this->type) {
            case self::TYPE_ARRAY:     return $this->data->getArrayCopy();
            case self::TYPE_ITERATOR:  return $this->data;
            case self::TYPE_AGGREGATE: return $this->data->getInnerIterator();
        }

        throw new \LogicException('Invalid data.');
    }

    /**
     * Peeks next entity.
     *
     * @return Entity|null
     */
    public function getPeek()
    {
        $this->peek = $this->next();

        return $this->peek;
    }
}
