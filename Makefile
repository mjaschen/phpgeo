.PHONY: docs
.PHONY: clean


docs: docs/phpgeo.html

docs/phpgeo.html: docs/phpgeo.adoc docs/piwik.html
	asciidoctor $<
	awk '/<\/body>/ { system("cat docs/piwik.html") }; {print} ' $@ > $@.tmp
	mv $@.tmp $@

clean:
	rm -f docs/phpgeo.html
