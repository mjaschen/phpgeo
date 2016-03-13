# Formatting

## Coordinates

You can format a coordinate in different styles.

### Decimal Degrees

```php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalDegrees;

$coordinate = new Coordinate(19.820664, -155.468066); // Mauna Kea Summit

echo $coordinate->format(new DecimalDegrees());
```

The code above produces the output below:

    19.82066 -155.46807

### Degrees/Minutes/Seconds (DMS)

```php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\DMS;

$coordinate = new Coordinate(18.911306, -155.678268); // South Point, HI, USA

$formatter = new DMS();

echo $coordinate->format($formatter) . PHP_EOL;

$formatter->setSeparator(", ")
    ->useCardinalLetters(true)
    ->setUnits(DMS::UNITS_ASCII);

echo $coordinate->format($formatter) . PHP_EOL;
```

The code above produces the output below:

    18° 54′ 41″ -155° 40′ 42″
    18° 54' 41" N, 155° 40' 42" W

### Decimal Minutes

This format is commonly used in the Geocaching community.

```php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalMinutes;

$coordinate = new Coordinate(43.62310, -70.20787); // Portland Head Light, ME, USA

$formatter = new DecimalMinutes();

echo $coordinate->format($formatter) . PHP_EOL;

$formatter->setSeparator(", ")
    ->useCardinalLetters(true)
    ->setUnits(DecimalMinutes::UNITS_ASCII);

echo $coordinate->format($formatter) . PHP_EOL;
```

The code above produces the output below:

    43° 37.386′ -070° 12.472′
    43° 37.386' N, 070° 12.472' W

### GeoJSON

```php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\GeoJSON;

$coordinate = new Coordinate(18.911306, -155.678268); // South Point, HI, USA

echo $coordinate->format(new GeoJSON());
```

The code above produces the output below:

```json
{"type":"Point","coordinates":[-155.678268,18.911306]}
```

## Polylines

You can format a polyline in different styles.

### GeoJSON

```php
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

```json
{"type":"LineString","coordinates":[[13.5,52.5],[14.5,62.5]]}
```

## Polygons

You can format a polygon in different styles.

### GeoJSON

```php
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

echo $formatter->format($polygon); // { "type" : "Polygon" , "coordinates" : [ [ 20, 10 ], [ 40, 20 ], [ 40, 30 ], [ 20, 30] ] }
```

The code above produces the output below:

```json
{"type":"Polygon","coordinates":[[20,10],[40,20],[40,30],[20,30]]}
```
