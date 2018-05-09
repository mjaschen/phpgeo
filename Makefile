.PHONY: docs
.PHONY: apidocs
.PHONY: clean

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
	scp docs/phpgeo.html phpgeo.marcusjaschen.de:phpgeo.marcusjaschen.de/index.html
	ssh phpgeo.marcusjaschen.de "mkdir -p phpgeo.marcusjaschen.de/api"
	rsync --recursive --delete docs/api/ phpgeo.marcusjaschen.de:phpgeo.marcusjaschen.de/api/
