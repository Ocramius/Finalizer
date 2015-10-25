# Finalizer

This library aims at providing simple tools that help deciding whether 
a class should or shouldn't be declared as `final`.

[![Build Status](https://travis-ci.org/Ocramius/Finalizer.svg?branch=master)](https://travis-ci.org/Ocramius/Finalizer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Ocramius/Finalizer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Ocramius/Finalizer/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Ocramius/Finalizer/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Ocramius/Finalizer/?branch=master)
[![Dependency Status](https://www.versioneye.com/package/php--ocramius--finalizer/badge.png)](https://www.versioneye.com/package/php--ocramius--finalizer)
[![HHVM Status](http://hhvm.h4cc.de/badge/ocramius/finalizer.png)](http://hhvm.h4cc.de/package/ocramius/finalizer)

[![Latest Stable Version](https://poser.pugx.org/ocramius/finalizer/v/stable.png)](https://packagist.org/packages/ocramius/finalizer)
[![Latest Unstable Version](https://poser.pugx.org/ocramius/finalizer/v/unstable.png)](https://packagist.org/packages/ocramius/finalizer)

## Help/Support

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/Ocramius/Finalizer)

## Installation

Install via [composer](https://getcomposer.org/):

```sh
php composer.phar require ocramius/finalizer:~1.0
```

## Usage

In your console, simply type:

```php
./vendor/bin/finalizer finalizer:check-final-classes path/to/directory
./vendor/bin/finalizer finalizer:check-final-classes also/supports multiple/directories as/parameters
```

Note that finalizer will take decisions on whether classes should or 
shouldn't be `final` depending on the classes defined in the directories
that you passed to it.

Additionally, be aware that `finalizer` will (in its current state) require
any of the PHP or Hack files in the given directories and include them via 
`require_once`.

## Reference

If you need to know more about why I wrote this library, and what kind of 
decisions it is doing, then please read 
[this blogpost about the usage of the `final` keyword](http://goo.gl/4eCCIK).
