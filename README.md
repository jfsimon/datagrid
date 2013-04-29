A datagrid component for PHP
============================

The main goal of this component is to render a result set from any data source as an HTML table
with sorting, filtering capabilities (ideal for backends).

Backlog
-------

- [ ] as a user I want to render a collection of strings (in-memory arrays) as an HTML table
- [ ] as a user I want to render a collection of mixed data (string, number, datetime) (in-memory arrays) as an HTML table
- [ ] as a user I want to get columns name in header
- [ ] as a user I want to automatically display CRUD links on each row

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

**This is not working yet, don't try this at home.**

```php
$schema = new Schema();
$schema
    ->add('title', 'string')
    ->add('publishedAt', 'datetime', array('format' => 'd/m/Y'))
    ->add('comments', 'count');

$collection = new Collection(array(
    array('title' => 'hello world!', 'publishedAt' => new \DateTime(), 'comments' => array('great')),
    array('title' => 'I\'m tired', 'publishedAt' => new \DateTime(), 'comments' => array()),
));

$factory = new Factory();
echo $factory
    ->createGrid($collection, array('schema' => $schema)
    ->render(new TwigRenderer($twig, 'my/template.html.twig'));
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

- Create a well coded component using Domain Development Design
- Make it highly extensible using open-close principle
- Depend on strong libraries to keep code lightweight
- Keep it open-source because I believe in it
- Get a good tests code coverage (not so easy)


Personal todo list
------------------

- [x] Implement an AST with visitor capability
- [x] Implement an easy way to build data grids
- [x] Implement Twig renderer
- [x] Implement standard data formatters
- [x] Write some tests
- [x] Improve exceptions (classes & messages)
- [x] Implement a labels extension
- [ ] Add acceptance tests
- [ ] Add sorting capability to labels
- [ ] Implement a debug extension
- [ ] Implement a Doctrine factory
- [ ] Write more tests
- [ ] Handle multi-columns/multi rows cells
- [ ] Implement a filter extension
- [ ] Manage data querying (sorting, filtering)
- [ ] Think about grouping data rows
