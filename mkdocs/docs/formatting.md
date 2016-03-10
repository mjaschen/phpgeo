# Formatting and Output

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

### Degrees/Minutes/Seconds (DMS)

```php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\DMS;

$coordinate = new Coordinate(18.911306, -155.678268); // South Point, HI, USA

$formatter = new DMS();

echo $coordinate->format($formatter); // 18° 54′ 41″ -155° 40′ 42″

$formatter->setSeparator(", ")
    ->useCardinalLetters(true)
    ->setUnits(DMS::UNITS_ASCII);

echo $coordinate->format($formatter); // 18° 54' 41" N, 155° 40' 42" W
```

### GeoJSON

```php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\GeoJSON;

$coordinate = new Coordinate(18.911306, -155.678268); // South Point, HI, USA

echo $coordinate->format(new GeoJSON()); // { "type" : "point" , "coordinates" : [ -155.678268, 18.911306 ] }
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

echo $formatter->format($polyline); // { "type" : "LineString" , "coordinates" : [ [ 13.5, 52.5 ], [ 14.5, 62.5 ] ] }
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
