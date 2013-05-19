Display a data table
====================

Previous step: [Get started](03_get_started.md).

1. Create a data collection
2. Create a schema
3. Use a factory to create grid
4. Render datagrid from your template

Create a data collection
------------------------

You need to instantiate a `Jfsimon\Datagrid\Model\Data\Collection` wrapping your data.
This class accept array or `\Traversable` instance as data.

```php
use Jfsimon\Datagrid\Model\Data\Collection;
```

```php
// assuming $data is an array or a \Traversable instance:
$collection = new Collection($data);
```

Create a schema
---------------

The schema describes the data to display by mapping data formatters to entities properties.
Look at [data formatters reference](71_data_formatters.md) to get a full list of available column types.

```php
use Jfsimon\Datagrid\Model\Schema;
```

```php
$schema = Schema::create()
    ->add('name', 'string')
    ->add('birthday', 'datetime', array('time_format' => \IntlDateFormatter::NONE))
    ->add('alive', 'boolean', array('true_value' => 'yes :)', 'false_value' => 'no :('))
;
```

Use a factory to create grid
----------------------------

The factory is responsible of datagrid creation. Simply instantiate a factory and call `createDatagrid()`
method to get what you need.

* First argument is your data `Collection` instance as seen above.
* Second argument is an array of options, see [factory options reference](72_factory_options.md) for a full list of available options.

```php
use Jfsimon\Datagrid\Infra\Factory\Factory;
```

```php
$factory = new Factory();
$grid = $factory->createGrid($collection, array('schema' => $schema));
```

Render datagrid from your template
----------------------------------

**/!\\** *For now only `Twig` template engine is supported. More systems to come.*

All you need is to pass the `$grid` object created above to your `Twig` template
and call the provided `datagrid()` function:

```twig
{# assuming 'grid' context var represents created grid: #}
{{ datagrid(grid) }}
```
