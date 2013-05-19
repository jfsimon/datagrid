Get started with datagrid component
===================================

Installation
------------

Datagrid component uses [composer](http://getcomposer.org/) and can be found on
[packagist](https://packagist.org/packages/jfsimon/datagrid).

As there is no tagged vbersion for now, you have to use `dev-master` version constraint.

```sh
$ ./composer.phar require jfsimon/datagrid:dev-master
```

If you want to contribute or run the unit tests, you'll have to install `dev` dependencies.

Run the tests
-------------

Tests need `dev` dependencies to be installed.

Datagrid component uses [PHPUnit](https://github.com/sebastianbergmann/phpunit/).
To run the tests, simply call phpunit from the root component directory:

```sh
$ phpunit
```

Or from your project root directory:

```sh
$ phpunit -c vendor/jfsimon/datagrid
```

About renderers
---------------

For now, there is only one renderer based on [Twig](http://twig.sensiolabs.org/) templating engine.
If you use another templating system, please [tell me](https://github.com/jfsimon/datagrid/issues/new),
I'll implement a renderer based on it.
