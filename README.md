A datagrid component for PHP [![Build Status](https://travis-ci.org/jfsimon/datagrid.png)](https://travis-ci.org/jfsimon/datagrid)
============================

The main goal of this component is to render a result set from any data source as an HTML table
with sorting and filtering capabilities (ideal for backends). This component aims to be
framework-agnostic and provide bindings for most used PHP frameworks.

* [Documentation summary](/doc/01_summary.md)
* [Development status](/doc/02_development_status.md)
* [Get started](/doc/03_get_started.md)
* [License MIT](/LICENSE)

To see the component in action, you can check accptance tests:
* [Data tests](/tests/Jfsimon/Datagrid/Tests/Acceptance/Data/DataTest.php)
* [Label tests](/tests/Jfsimon/Datagrid/Tests/Acceptance/Label/LabelTest.php)
* [Actions tests](/tests/Jfsimon/Datagrid/Tests/Acceptance/Actions/ActionsTest.php)

---

Create CRUD actions:

```php
$actions = Actions::enable()
    ->addGlobalRoute('create', 'beatle_create')
    ->addEntityRoute('read', 'beatle_read', array('beatle' => 'slug'))
    ->addEntityRoute('update', 'beatle_update', array('beatle' => 'slug'))
    ->addEntityRoute('delete', 'beatle_delete', array('beatle' => 'slug'))
;
```

1 - Usage with custom data:

```php
$beatles = array(
  array('slug' => 'john',    'name' => 'John Lenon',       'birthday' => new \DateTime('1940-10-09'), 'alive' => false),
  array('slug' => 'paul',    'name' => 'Paul McCartney',   'birthday' => new \DateTime('1942-06-18'), 'alive' => true),
  array('slug' => 'georges', 'name' => 'Georges Harrison', 'birthday' => new \DateTime('1943-02-25'), 'alive' => false),
  array('slug' => 'ringo',   'name' => 'Ringo Starr',      'birthday' => new \DateTime('1940-07-07'), 'alive' => true),
);
$schema = Schema::create()
    ->add('name', 'string', array('label' => 'Member name')
    ->add('birthday', 'datetime', array('time_format' => \IntlDateFormatter::NONE))
    ->add('alive', 'boolean', array('label' => 'Still alive?', 'false_value' => 'no more :('))
;
$factory = new Factory();
$grid = $factory->createGrid(new Collection($beatles), array('schema' => $schema, 'actions' => $actions));
echo  $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));
```

2 - Usage with Doctrine:

```php
$factory = new DoctrineFactory($em);
echo $factory
    ->createGrid(new Collection($em->findAll('Beatle')), array('actions' => $actions))
    ->render(new TwigRenderer($twig, 'beatles.html.twig'));
```

Both will render:

Member name      | Birthday     | Still alive? | [Create](/beatles/create)
-----------------|--------------|--------------|--------------------------
John Lenon       | Oct 9, 1940  | no more :(   | [Read](/beatles/read/john) [Update](/beatles/update/john) [Delete](/beatles/delete/john)
Paul McCartney   | Jun 18, 1942 | yes          | [Read](/beatles/read/paul) [Update](/beatles/update/paul) [Delete](/beatles/delete/paul)
Georges Harrison | Feb 25, 1943 | no more :(   | [Read](/beatles/read/georges) [Update](/beatles/update/georges) [Delete](/beatles/delete/georges)
Ringo Starr      | Jul 7, 1940  | yes          | [Read](/beatles/read/ringo) [Update](/beatles/update/ringo) [Delete](/beatles/delete/ringo)
