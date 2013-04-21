A datagrid component for PHP
============================

Objectives
----------

- Create a well coded component using Domain Development Design
- Make it highly extensible using open-close principle
- Depend on strong libraries to keep code lightweight
- Keep it open-source because I believe in it
- Get a good tests code coverage (not so easy)

Work in progress
----------------

- [x] Implement an AST with visitor capability
- [x] Implement an easy way to build datagrid
- [ ] Implement Twig & PHP renderer
- [ ] Implement standard data formatters
- [ ] Write some tests
- [ ] Implement a labels extension
- [ ] Implement a Doctrine factory
- [ ] Write more tests

Usage with custom data
----------------------

**This is not working yet, don't try this at home.**

```php
$factory = new Factory();

$schema = Schema::create($factory->createRegistry())
    ->add('title', 'string')
    ->add('publishedAt', 'datetime', array('format' => 'd/m/Y'))
    ->add('comments', 'count');

$collection = new Collection(array(
    array('title' => 'hello world!', 'publishedAt' => new \DateTime(), 'comments' => array('great')),
    array('title' => 'I\'m tired', 'publishedAt' => new \DateTime(), 'comments' => array()),
));

echo $factory
    ->create($collection, array('schema' => $schema)
    ->render(new TwigRenderer($twig, 'my/template.html.twig');
```

Usage with Doctrine
-------------------

**This is not working yet, don't try this at home.**

```php
$factory = new DoctrineFactory($em);

echo $factory
    ->create(new Collection($em->findAll('My:Article')))
    ->render(new TwigRenderer($twig, 'my/template.html.twig');
```
