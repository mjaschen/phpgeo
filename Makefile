.PHONY: docs
.PHONY: clean

docs: docs/phpgeo.html

docs/phpgeo.html: docs/phpgeo.adoc
	asciidoctor $<

clean:
	rm -f docs/phpgeo.html
