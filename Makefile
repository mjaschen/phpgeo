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
	mkdir -p build
	mkdir -p build/coverage
	mkdir -p docs/coverage
	mkdir -p docs/phpdox
	./tools/phploc --log-xml=build/phploc.xml src tests
	./tools/phpcs --report-xml=build/phpcs.xml src
	./tools/phpunit --coverage-xml build/coverage --coverage-html docs/coverage
	./tools/phpdox -f docs/phpdox.xml

clean:
	rm -f docs/phpgeo.html
	rm -Rf docs/coverage
	rm -Rf docs/phpdox
	rm -Rf build/coverage
	rm -Rf build/phpdox
	rm -Rf build/phpcs.xml
	rm -Rf build/phploc.xml

upload_docs: docs
	scp docs/phpgeo.html $(UPLOAD_HOST):$(UPLOAD_PATH)/index.html
	ssh $(UPLOAD_HOST) "mkdir -p $(UPLOAD_PATH)/api"
	rsync --recursive --delete docs/phpdox/ $(UPLOAD_HOST):$(UPLOAD_PATH)/api/

ci: lint coding-standards composer-validate sniff static-analysis-psalm unit-tests

coding-standards: sniff

composer-validate:
	composer validate --no-check-publish

lint:
	./vendor/bin/parallel-lint src

sniff:
	-./tools/phpcs --standard=codesniffer_rules.xml src

static-analysis-psalm:
	./tools/psalm

unit-tests:
	./tools/phpunit
