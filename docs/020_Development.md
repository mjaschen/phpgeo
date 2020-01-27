# Development

## Run Tests

_phpgeo_ provides unit tests with a quite good coverage. For an easy usage,
the test command is wrapped as a Composer script:

``` shell
composer ci:tests
```

Of course it's possible to run PHPUnit directly:

``` shell
./tools/phpunit
```

To test against another PHP version you can use Docker. The following command runs
the tests using PHP 7.1:

``` shell
docker run -it --rm --name phpgeo-phpunit \
    -v "$PWD":/usr/src/phpgeo \
    -w /usr/src/phpgeo php:7.1-cli \
    php tools/phpunit
```

Or using PHP 7.2:

``` shell
docker run -it --rm --name phpgeo-phpunit \
    -v "$PWD":/usr/src/phpgeo \
    -w /usr/src/phpgeo php:7.2-cli \
    php tools/phpunit
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

As of version 0.12.0 Daux throws lots of deprecation warnings with PHP 7.4. Using PHP 7.3 is a workaround:

``` shell
PHP=/usr/local/opt/php@7.3/bin/php make docs
```
