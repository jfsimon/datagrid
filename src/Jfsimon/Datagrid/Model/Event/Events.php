<?php

namespace Jfsimon\Datagrid\Model\Event;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Events
{
    const OPTIONS_SET      = 'options.set';
    const OPTIONS_RESOLVED = 'options.resolved';
    const SCHEMA_BUILT     = 'schema.built';
    const SCHEMA_GUESSED   = 'schema.guessed';
    const GRID_BUILT       = 'grid.built';
    const GRID_VISITED     = 'grid.visited';
}
