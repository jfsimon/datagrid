A datagrid component for PHP
============================

The main goal of this component is to render a result set from any data source as an HTML table
with sorting, filtering capabilities (ideal for backends).

[![Build Status](https://travis-ci.org/jfsimon/datagrid.png)](https://travis-ci.org/jfsimon/datagrid)

Backlog
-------

- [x] as a user I want to render a collection of strings (in-memory arrays) as an HTML table
- [x] as a user I want to render a collection of mixed data (string, number, datetime) (in-memory arrays) as an HTML table
- [x] as a user I want to get columns name in header
- [x] as a user I want to automatically display CRUD links on each row
- [x] as a user I want to translate columns label
- [x] as a user I want to translate actions label
- [x] as a user I want to use router for action links
- [ ] as a user I want to add classes to HTML tags

Icebox
------

- [ ] as a user I want to use Doctrine as data source
- [ ] as a user I want to paginate results
- [ ] as a user I want to sort data by column names asc/desc
- [ ] as a user I want to filter string data with an input HTML tag using fuzzy match
- [ ] as a user I want to filter datetime data using datetime boundaries
- [ ] as a user I want to apply CRUD actions on multiple rows at the same time

Usage with custom data
----------------------

1. Wrap your data with `Collection` object.
2. Define your columns schema.
3. Create a grid using a `Factory` instance.
4. Render your grid within templates thanks to provided `Twig` extension.


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
    ->add('alive', 'boolean', array('label' => 'Still alive?', 'false_value' => 'no more'))
;

$factory = new Factory();
$grid = $factory->createGrid(new Collection($quarks), array('schema' => $schema));
$html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));
```

Usage with Doctrine
-------------------

**This is not working yet, don't try this at home.**

```php
$factory = new DoctrineFactory($em);

echo $factory
    ->createGrid(new Collection($em->findAll('My:Article')))
    ->render(new TwigRenderer($twig, 'my/template.html.twig'));
```

Personal objectives
-------------------

- Create a well coded component using Domain Development Design.
- Make it highly extensible using open-close principle.
- Depend on strong libraries to keep code lightweight.
- Keep it open-source because I believe in it (license MIT).
- Cover 100% of code with tests.
- Keep as framework-agnostic as possible.

Personal todo list
------------------

- [x] Implement an AST with visitor capability
- [x] Implement an easy way to build data grids
- [x] Implement Twig renderer
- [x] Implement standard data formatters
- [x] Write some tests
- [x] Improve exceptions (classes & messages)
- [x] Implement a labels extension
- [x] Implement an actions extension
- [x] Add acceptance tests
- [x] Add translator support
- [ ] Add HTML class visitor
- [ ] Add sorting capability to labels
- [ ] Implement a debug extension
- [ ] Implement a Doctrine factory
- [ ] Handle multi-columns/multi rows cells
- [ ] Implement a filter extension
- [ ] Manage data querying (sorting, filtering)
- [ ] Think about grouping data rows
