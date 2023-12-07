# Getting phpgeo

## Requirements

*phpgeo* requires at least PHP 8.1.

The 4.x releases require PHP >= 7.3 but don't get feature updates any longer. Bugfixes will be backported.

The 3.x releases require PHP >= 7.2 but don't get feature updates any longer. Bugfixes won't be backported.

The 2.x releases require PHP >= 7.0 but don't get feature updates any longer. Bugfixes won't be backported.

The 1.x release line has support for PHP >= 5.4. Bugfixes won't be backported.

### Compatibility Matrix

| PHP Version | phpgeo Version | Support Status   | Composer Install                         |
|:-----------:|:--------------:|:----------------:|------------------------------------------|
| 8.2         | 4.x            | ✅ active         | `composer require mjaschen/phpgeo`      |
| 8.1         | 4.x            | ✅ active         | `composer require mjaschen/phpgeo`      |
| 8.0         | 4.x            | ✅ active         | `composer require mjaschen/phpgeo`      |
| 7.4         | 4.x            | ✅ active         | `composer require mjaschen/phpgeo`      |
| 7.3         | 4.x            | ✅ active         | `composer require mjaschen/phpgeo`      |
| 7.2         | 3.x            | ⚠️ security only   | `composer require mjaschen/phpgeo:^3.0` |
| 7.1         | 2.x            | ❌ end of life     | `composer require mjaschen/phpgeo:^2.0` |
| 7.0         | 2.x            | ❌ end of life     | `composer require mjaschen/phpgeo:^2.0` |
| 5.6         | 1.x            | ❌ end of life     | `composer require mjaschen/phpgeo:^1.0` |
| 5.5         | 1.x            | ❌ end of life     | `composer require mjaschen/phpgeo:^1.0` |
| 5.4         | 1.x            | ❌ end of life     | `composer require mjaschen/phpgeo:^1.0` |

## Installation

*phpgeo* is best be installed using Composer. Please visit the
[Composer website](https://getcomposer.org/) for more information.

To install *phpgeo,* simply “require” it using Composer:

``` shell
composer require mjaschen/phpgeo
```

*phpgeo* is now ready to be used in your project!
