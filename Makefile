.PHONY: docs
.PHONY: apidocs
.PHONY: clean
.PHONY: ci
.PHONY: coding-standards
.PHONY: composer-validate
.PHONY: lint
.PHONY: sniff
.PHONY: static-analysis-psalm
.PHONY: unit-tests

docs: docs/phpgeo.html apidocs

docs/phpgeo.html: docs/phpgeo.adoc docs/piwik.html
	asciidoctor $< || { rm $@ ; exit 1 ; }
	awk '/<\/body>/ { system("cat docs/piwik.html") }; {print} ' $@ > $@.tmp
	mv $@.tmp $@

apidocs:
	phpdoc run -d src -t docs/api

clean:
	rm -f docs/phpgeo.html
	rm -Rf docs/api

upload_docs: docs
	scp docs/phpgeo.html phpgeo.marcusjaschen.de:phpgeo.marcusjaschen.de/index.html
	ssh phpgeo.marcusjaschen.de "mkdir -p phpgeo.marcusjaschen.de/api"
	rsync --recursive --delete docs/api/ phpgeo.marcusjaschen.de:phpgeo.marcusjaschen.de/api/

ci: lint coding-standards composer-validate sniff static-analysis-psalm unit-tests

coding-standards: sniff
	./vendor/bin/phpmd src text cleancode,codesize,controversial,design,naming,unusedcode

composer-validate:
	composer validate --no-check-publish

lint:
	./vendor/bin/parallel-lint src

sniff:
	./vendor/bin/phpcs --standard=codesniffer_rules.xml src

static-analysis-psalm:
	./vendor/bin/psalm

unit-tests:
	./vendor/bin/phpunit
