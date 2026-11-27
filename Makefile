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

.PHONY: ci coding-standards composer-validate lint sniff static-analysis static-analysis-psalm unit-tests
ci:
	composer ci

coding-standards: sniff

composer-validate:
	composer ci:composer-validate

lint:
	composer ci:lint

sniff:
	composer ci:sniff

static-analysis-psalm: static-analysis

static-analysis:
	composer ci:phpstan

unit-tests:
	composer ci:tests
