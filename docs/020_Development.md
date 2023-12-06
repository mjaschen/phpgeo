# Development

## Run Tests

*phpgeo* provides unit tests with a quite good coverage. For an easy usage,
the test command is wrapped as a Composer script:

``` shell
composer ci:tests
```

Of course, it's possible to run PHPUnit directly:

``` shell
./vendor/bin/phpunit
```

To test against another PHP version you can use Docker. The following command runs
the tests using PHP 8.3:

``` shell
docker run -it --rm --name phpgeo-phpunit \
    -v "$PWD":/usr/src/phpgeo \
    -w /usr/src/phpgeo php:8.3-cli \
    php vendor/bin/phpunit
```

Alongside with the unit tests, static test runners are also provided. Run the lint
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

… or run all CI tasks with different PHP versions one after another:

```shell
for PHP_VERSION in 8.1 8.2 8.3 ; do \
  docker run -it --rm -v "$PWD":/phpgeo -w /phpgeo \
  ghcr.io/mjaschen/php:${PHP_VERSION}-cli-mj composer ci || break ; \
done
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
