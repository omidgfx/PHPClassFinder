ClassFinder
===========

A dead simple utility to identify classes in a given namespace.

This package is an improved implementation of an [answer on Stack Overflow](https://stackoverflow.com/a/40229665/3000068)
and provides additional features with less configuration required.

Requirements
------------

* Application is using Composer.
* Classes can be autoloaded with Composer.
* PHP >= 5.3.0

Installing
----------

Installing is done by requiring it with Composer.

```
composer require haydenpierce/class-finder
```

No other installation methods are currently supported.

Supported Autoloading Methods
--------------------------------

| Method     | Supported | with `ClassFinder::RECURSIVE_MODE` |
| ---------- | --------- | ---------------------------------- |
| PSR-4      | ✔️     | ✔️                               |
| PSR-0      | ❌️*   | ❌️*                             |
| Classmap   | ✔️     | ✔️                               |
| Files      | ✔️^    | ❌️**                            |

\^ Experimental.

\* Planned.

\** Not planned. Open an issue if you need this feature.

Examples
--------

**Standard Mode**

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

ClassFinder::disablePSR4Vendors();
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

**Recursive Mode** *(in v0.3-beta)*

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

ClassFinder::disablePSR4Vendors();
$classes = ClassFinder::getClassesInNamespace('TestApp1\Foo', ClassFinder::RECURSIVE_MODE);

/**
 * array(
 *   'TestApp1\Foo\Bar',
 *   'TestApp1\Foo\Baz',
 *   'TestApp1\Foo\Foo',
 *   'TestApp1\Foo\Box\Bar',
 *   'TestApp1\Foo\Box\Baz',
 *   'TestApp1\Foo\Box\Foo',
 *   'TestApp1\Foo\Box\Lon\Bar',
 *   'TestApp1\Foo\Box\Lon\Baz',
 *   'TestApp1\Foo\Box\Lon\Foo',
 * )
 */
var_dump($classes);
```

Performance
-----------

Most applications and libraries rely on PSR4 to autoload classes. To detect these classes, ClassFinder scans your 
application's files to check for classes in various directories. By default, ClassFinder will also scan 3rd party classes
in the vendor directory to locate potential classes in the provided namespace. This can be terribly slow if your application
has lots of 3rd party code. You can preemptively ignore these classes with `ClassFinder:disablePSR4Vendors()` - when this is
called, subsequent calls to `ClassFinder::getClassesInNamespace()` will skip scanning anything in the vendor directory.
 
Documentation
-------------

[Changelog](docs/changelog.md)

**Exceptions**:

* [Files could not locate PHP](docs/exceptions/filesCouldNotLocatePHP.md)
* [Files exec not available](docs/exceptions/filesExecNotAvailable.md)
* [Missing composer.json](docs/exceptions/missingComposerConfig.md)

**Internals**

* [How Testing Works](docs/testing.md)
* [Continuous Integration Notes](docs/ci.md)

Future Work
-----------

> **WARNING**: Before 1.0.0, expect that bug fixes _will not_ be backported to older versions. Backwards incompatible changes
may be introduced in minor 0.X.Y versions, where X changes.

* `psr0` support

* Additional features: 

Various ideas:

* ~~`ClassFinder::getClassesInNamespace('TestApp1\Foo', ClassFinder::RECURSIVE_MODE)`. 
Providing classes multiple namespaces deep.~~ (included v0.3-beta)

* `ClassFinder::getClassesImplementingInterface('TestApp1\Foo', 'TestApp1\FooInterface', ClassFinder::RECURSIVE_MODE)`.
Filtering classes to only classes that implement a namespace.

* `ClassFinder::debugRenderReport('TestApp1\Foo\Baz')` 
Guidance for solving "class not found" errors resulting from typos in namespaces, missing directories, etc. Would print
an HTML report. Not intended for production use, but debugging.
