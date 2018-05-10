.PHONY: apidocs
.PHONY: clean
.PHONY: docs
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

docs: docs/phpgeo.html apidocs

docs/phpgeo.html: docs/phpgeo.adoc docs/piwik.html
	asciidoctor $< || { rm $@ ; exit 1 ; }
	awk '/<\/body>/ { system("cat docs/piwik.html") }; {print} ' $@ > $@.tmp
	mv $@.tmp $@

apidocs:
	mkdir -p docs/api
	mkdir -p docs/cache
	sami update docs/sami.config.php

clean:
	rm -f docs/phpgeo.html
	rm -Rf docs/api

upload_docs: docs
	scp docs/phpgeo.html $(UPLOAD_HOST):$(UPLOAD_PATH)/index.html
	ssh $(UPLOAD_HOST) "mkdir -p $(UPLOAD_PATH)/api"
	rsync --recursive --delete docs/api/ $(UPLOAD_HOST):$(UPLOAD_PATH)/api/

ci: lint coding-standards composer-validate sniff static-analysis-psalm unit-tests

coding-standards: sniff
	-./vendor/bin/phpmd src text cleancode,codesize,design,naming,unusedcode

composer-validate:
	composer validate --no-check-publish

lint:
	./vendor/bin/parallel-lint src

sniff:
	-./vendor/bin/phpcs --standard=codesniffer_rules.xml src

static-analysis-psalm:
	./vendor/bin/psalm

unit-tests:
	./vendor/bin/phpunit
