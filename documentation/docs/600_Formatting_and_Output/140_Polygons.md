# Formatting Polygons

You can format a polygon in different styles.

## GeoJSON

``` php
<?php

use Location\Coordinate;
use Location\Polygon;
use Location\Formatter\Polygon\GeoJSON;

$polygon = new Polygon;
$polygon->addPoint(new Coordinate(10, 20));
$polygon->addPoint(new Coordinate(20, 40));
$polygon->addPoint(new Coordinate(30, 40));
$polygon->addPoint(new Coordinate(30, 20));

$formatter = new GeoJSON;

echo $formatter->format($polygon);
```

The code above produces the output below:

``` json
{"type":"Polygon","coordinates":[[20,10],[40,20],[40,30],[20,30]]}
```

NOTE: Float values processed by `json_encode()` are affected by the ini-setting
[`serialize_precision`](https://secure.php.net/manual/en/ini.core.php#ini.serialize-precision).
You can change the number of decimal places in the JSON output by changing
that ini-option, e. g. with `ini_set('serialize_precision', 8)`.
