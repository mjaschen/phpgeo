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

A static code analysis with [PHPStan](https://phpstan.org/) is configured as well:

``` shell
composer ci:phpstan
```

Run `composer ci:sniff` to check coding standards with PHP_CodeSniffer.

Run all checks and tests with:

``` shell
composer ci
```

GitHub Actions runs these checks on PHP 8.2, 8.3, 8.4, 8.5, and 8.6.
For a local run, install dependencies with `composer install` using the PHP
version you want to test, then run `composer ci`.

## Creating the documentation

*phpgeo's* documentation is generated with [Material for
MkDocs](https://squidfunk.github.io/mkdocs-material/) from Markdown files. The
`Makefile` provides a helper target for generating the complete documentation:

```shell
make docs
```

The documentation project is managed with [uv](https://docs.astral.sh/uv/). To
install its locked dependencies directly, run:

```shell
uv sync --directory documentation --frozen
```

To preview the site locally with live reload:

```shell
make serve-docs
```
