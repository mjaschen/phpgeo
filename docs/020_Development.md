# Development

## Run Tests

_phpgeo_ provides unit tests with a quite good coverage. For an easy usage,
the test command is wrapped as a Composer script:

``` shell
composer ci:tests
```

Of course it's possible to run PHPUnit directly:

``` shell
./vendor/bin/phpunit
```

To test against another PHP version you can use Docker. The following command runs
the tests using PHP 7.2:

``` shell
docker run -it --rm --name phpgeo-phpunit \
    -v "$PWD":/usr/src/phpgeo \
    -w /usr/src/phpgeo php:7.2-cli \
    php vendor/bin/phpunit
```

Or using PHP 7.3:

``` shell
docker run -it --rm --name phpgeo-phpunit \
    -v "$PWD":/usr/src/phpgeo \
    -w /usr/src/phpgeo php:7.3-cli \
    php vendor/bin/phpunit
```

Or PHP 7.4:

``` shell
docker run -it --rm --name phpgeo-phpunit \
    -v "$PWD":/usr/src/phpgeo \
    -w /usr/src/phpgeo php:7.4-cli \
    php vendor/bin/phpunit
```

PHP 8.0:

``` shell
docker run -it --rm --name phpgeo-phpunit \
    -v "$PWD":/usr/src/phpgeo \
    -w /usr/src/phpgeo php:8.0-cli \
    php vendor/bin/phpunit
```

Besides the unit tests, static test runners are also provided. Run the lint
command to ensure the sources don't contain any syntax error:

``` shell
composer ci:lint
```

A static code analysis with [Psalm](https://psalm.dev/) is configured as well:

``` shell
composer ci:psalm
```

It's possible to run all tests at once:

``` shell
composer ci
```

## Creating the documentation

*phpgeo's* documentation is generated with [Daux](https://daux.io/) from Markdown files.
The `Makefile` provides a helper target for generating the complete documentation:

``` shell
make docs
```

*Daux* can also be run from its official Docker image:

``` shell
docker run --rm -it -v "$(pwd)":/phpgeo -w /phpgeo daux/daux.io daux generate -d build/daux
```

### API Documentation

*phpgeo's* API documentation is generated with *[phpdox](http://phpdox.de/):*

```shell
make apidocs
```
