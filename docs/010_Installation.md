# Getting phpgeo

## Requirements

_phpgeo_ requires at least PHP 7.3. _phpgeo_ fully supports PHP 8.

The 3.x releases require PHP >= 7.2 but don't get feature updates any longer. Bugfixes will be backported.

The 2.x releases require PHP >= 7.0 but don't get feature updates any longer. Bugfixes won't be backported.

The 1.x release line has support for PHP >= 5.4. Bugfixes won't be backported.

## Installation

_phpgeo_ is best be installed using Composer. Please visit the
[Composer website](https://getcomposer.org/) website for more information.

To install _phpgeo,_ simply “require” it using Composer:

``` shell
composer require mjaschen/phpgeo
```

_phpgeo_ is now ready to be used in your project!

## Installation of Development Tools

Most of the development dependencies are managed with [Phive](https://phar.io/).

For that you have to install Phive first. Now a simple `phive install -c` fetches all required Phar archives and installs them into the `tools` directory.
