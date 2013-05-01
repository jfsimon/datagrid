A datagrid component for PHP
============================

The main goal of this component is to render a result set from any data source as an HTML table
with sorting, filtering capabilities (ideal for backends).

Backlog
-------

- [x] as a user I want to render a collection of strings (in-memory arrays) as an HTML table
- [x] as a user I want to render a collection of mixed data (string, number, datetime) (in-memory arrays) as an HTML table
- [x] as a user I want to get columns name in header
- [x] as a user I want to automatically display CRUD links on each row
- [x] as a user I want to be able to translate columns label
- [ ] as a user I want to be able to translate actions label
- [ ] as a user I want to be able to add classes to HTML tags

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
$quarks = array(
    array('name' => 'Up',      'generation' => 'first',  'charge' => '+2/3', 'antiparticle' => 'Antiup'),
    array('name' => 'Down',    'generation' => 'first',  'charge' => '-1/3', 'antiparticle' => 'Antidown'),
    array('name' => 'Charm',   'generation' => 'second', 'charge' => '+2/3', 'antiparticle' => 'Anticharm'),
    array('name' => 'Strange', 'generation' => 'second', 'charge' => '-1/3', 'antiparticle' => 'Antistrange'),
    array('name' => 'Top',     'generation' => 'third',  'charge' => '+2/3', 'antiparticle' => 'Antitop'),
    array('name' => 'Bottom',  'generation' => 'third',  'charge' => '-1/3', 'antiparticle' => 'Antibottom'),
);

$schema = new Schema();
$schema
    ->add('name', 'string')
    ->add('generation', 'string')
    ->add('charge', 'string')
    ->add('antiparticle', 'string')
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

- Create a well coded component using Domain Development Design
- Make it highly extensible using open-close principle
- Depend on strong libraries to keep code lightweight
- Keep it open-source because I believe in it (license MIT)
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
- [x] Implement an actions extension
- [x] Add acceptance tests
- [x] Add translator support
- [ ] Add HTML class visitor
- [ ] Add sorting capability to labels
- [ ] Implement a debug extension
- [ ] Implement a Doctrine factory
- [ ] Write more tests
- [ ] Handle multi-columns/multi rows cells
- [ ] Implement a filter extension
- [ ] Manage data querying (sorting, filtering)
- [ ] Think about grouping data rows
