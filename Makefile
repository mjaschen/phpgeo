.PHONY: apidocs
.PHONY: clean
.PHONY: docs
.PHONY: daux
.PHONY: upload_docs

.PHONY: ci
.PHONY: coding-standards
.PHONY: composer-validate
.PHONY: lint
.PHONY: sniff
.PHONY: static-analysis-psalm
.PHONY: unit-tests

UPLOAD_HOST=phpgeo.marcusjaschen.de
UPLOAD_PATH=phpgeo.marcusjaschen.de

PHP ?= php

docs: daux apidocs

daux:
	rm -Rf build/daux
	mkdir -p build/daux
	$(PHP) vendor/bin/daux generate -d build/daux

apidocs:
	mkdir -p build
	mkdir -p build/coverage
	$(PHP) ./tools/phploc --log-xml=build/phploc.xml src tests
	$(PHP) ./tools/phpcs --report-xml=build/phpcs.xml src
	$(PHP) ./tools/phpunit --coverage-xml build/coverage --coverage-html build/coverage
	$(PHP) ./tools/phpdox

clean:
	rm -Rf build

upload_docs: docs
	rsync --recursive --delete build/daux/ $(UPLOAD_HOST):$(UPLOAD_PATH)/
	ssh $(UPLOAD_HOST) "mkdir -p $(UPLOAD_PATH)/api"
	rsync --recursive --delete build/apidocs/html/ $(UPLOAD_HOST):$(UPLOAD_PATH)/api/

ci: lint coding-standards composer-validate sniff static-analysis-psalm unit-tests

coding-standards: sniff

composer-validate:
	composer validate --no-check-publish

lint:
	$(PHP) ./vendor/bin/parallel-lint src

sniff:
	# the `-` prefix ignores the exit status of the command
	-$(PHP) ./tools/phpcs --standard=codesniffer_rules.xml src

static-analysis-psalm:
	$(PHP) ./tools/psalm

unit-tests:
	$(PHP) ./tools/phpunit
