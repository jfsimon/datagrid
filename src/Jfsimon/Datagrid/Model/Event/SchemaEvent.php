<?php

namespace Jfsimon\Datagrid\Model\Event;

use Jfsimon\Datagrid\Model\Schema;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class SchemaEvent extends Event
{
    /**
     * @var Schema
     */
    private $schema;

    /**
     * @param Schema $schema
     */
    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * @param Schema $schema
     *
     * @return SchemaEvent
     */
    public function setSchema(Schema $schema)
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * @return Schema
     */
    public function getSchema()
    {
        return $this->schema;
    }
}
