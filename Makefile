UPLOAD_HOST=phpgeo.marcusjaschen.de
UPLOAD_PATH=phpgeo.marcusjaschen.de

PHP ?= php

.PHONY: docs
docs: daux apidocs

.PHONY: daux
daux:
	rm -Rf build/daux
	mkdir -p build/daux
	$(PHP) vendor/bin/daux generate -d build/daux

.PHONY: apidocs
apidocs:
	mkdir -p build
	mkdir -p build/coverage
	$(PHP) ./vendor/bin/phploc --log-xml=build/phploc.xml src tests
	$(PHP) ./vendor/bin/phpcs --report-xml=build/phpcs.xml src
	$(PHP) ./vendor/bin/phpunit --coverage-xml build/coverage --coverage-html build/coverage
	$(PHP) ./vendor/bin/phpdox

.PHONY: clean
clean:
	rm -Rf build

.PHONY: upload_docs
upload_docs: docs
	rsync --recursive --delete build/daux/ $(UPLOAD_HOST):$(UPLOAD_PATH)/
	ssh $(UPLOAD_HOST) "mkdir -p $(UPLOAD_PATH)/api"
	rsync --recursive --delete build/apidocs/html/ $(UPLOAD_HOST):$(UPLOAD_PATH)/api/

.PHONY: ci
ci: lint coding-standards composer-validate sniff static-analysis-psalm unit-tests

.PHONY: coding-standards
coding-standards: sniff

.PHONY: composer-validate
composer-validate:
	composer validate --no-check-publish

.PHONY: lint
lint:
	$(PHP) ./vendor/bin/parallel-lint src

.PHONY: sniff
sniff:
	# the `-` prefix ignores the exit status of the command
	-$(PHP) ./vendor/bin/phpcs --standard=codesniffer_rules.xml src

.PHONY: static-analysis-psalm
static-analysis-psalm:
	$(PHP) ./vendor/bin/psalm

.PHONY: unit-tests
unit-tests:
	$(PHP) ./vendor/bin/phpunit
