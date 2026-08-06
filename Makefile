UPLOAD_HOST=phpgeo.marcusjaschen.de
UPLOAD_PATH=phpgeo.marcusjaschen.de

PHP ?= php
UV ?= uv

.PHONY: docs
docs: daux

.PHONY: daux
daux:
	rm -Rf build/documentation
	mkdir -p build/documentation
	cd documentation && \
		$(UV) sync --frozen && \
		$(UV) run --frozen mkdocs build -d ../build/documentation

.PHONY: serve-docs
serve-docs:
	cd documentation && \
		$(UV) sync --frozen && \
		$(UV) run --frozen mkdocs serve -f mkdocs.yml --livereload --watch docs --watch mkdocs.yml

.PHONY: clean
clean:
	rm -Rf build

.PHONY: upload_docs
upload_docs: docs
	rsync --recursive --delete build/documentation/ $(UPLOAD_HOST):$(UPLOAD_PATH)/

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
