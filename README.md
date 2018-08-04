ClassFinder
===========

A lightweight utility to identify classes in a given namespace.  This package is an improved implementation of an
 [answer on Stack Overflow](https://stackoverflow.com/a/40229665/3000068) that provides additional features with less
 configuration required.

Requirements
------------

 * Application is using Composer.
 * Classes are compliant with PSR-4.
 * PHP >= 5.3.0
 
Installing
----------

Installing is done by requiring it with Composer.

```
$ composer require haydenpierce/class-finder
```

No other installation methods are currently supported.

Example
-------

```
<?php

require_once __DIR__ . '/vendor/autoload.php';

$classes = ClassFinder::getClassesInNamespace('TestApp1\Foo');

/**
 * array(
 *   'TestApp1\Foo\Bar',
 *   'TestApp1\Foo\Baz',
 *   'TestApp1\Foo\Foo'
 * )
 */
var_dump($classes);
```
 