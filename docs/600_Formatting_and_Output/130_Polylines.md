# Formatting Polylines

You can format a polyline in different styles.

## GeoJSON

``` php
<?php

use Location\Coordinate;
use Location\Polyline;
use Location\Formatter\Polyline\GeoJSON;

$polyline = new Polyline;
$polyline->addPoint(new Coordinate(52.5, 13.5));
$polyline->addPoint(new Coordinate(62.5, 14.5));

$formatter = new GeoJSON;

echo $formatter->format($polyline);
```

The code above produces the output below:

``` json
{"type":"LineString","coordinates":[[13.5,52.5],[14.5,62.5]]}
```

NOTE: Float values processed by `json_encode()` are affected by the ini-setting
[`serialize_precision`](https://secure.php.net/manual/en/ini.core.php#ini.serialize-precision).
You can change the number of decimal places in the JSON output by changing
that ini-option, e. g. with `ini_set('serialize_precision', 8)`.
