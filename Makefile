.PHONY: docs
.PHONY: apidocs
.PHONY: clean


docs: docs/phpgeo.html apidocs

docs/phpgeo.html: docs/phpgeo.adoc docs/piwik.html
	asciidoctor $<
	awk '/<\/body>/ { system("cat docs/piwik.html") }; {print} ' $@ > $@.tmp
	mv $@.tmp $@

apidocs:
	yes | apigen generate

clean:
	rm -f docs/phpgeo.html
	rm -Rf docs/api
