# phpgeo - A Simple Geo Library for PHP

phpgeo provides abstractions to geographical coordinates (including support for different ellipsoids) and allows you to calculate geographical distances between coordinates with high precision.

<!-- MarkdownTOC autolink=true bracket=round depth=0 autoanchor=false -->

- [Requirements](#requirements)
- [Documentation](#documentation)
- [Installation](#installation)
- [Features](#features)
- [Examples/Usage](#examplesusage)
  - [Distance between two coordinates \(Vincenty's Formula\)](#distance-between-two-coordinates-vincentys-formula)
  - [Simplifying a polyline](#simplifying-a-polyline)
  - [Polygon contains a point \(e.g. "GPS geofence"\)](#polygon-contains-a-point-eg-gps-geofence)
  - [Formatted output of coordinates](#formatted-output-of-coordinates)
    - [Decimal Degrees](#decimal-degrees)
    - [Degrees/Minutes/Seconds \(DMS\)](#degreesminutesseconds-dms)
    - [GeoJSON](#geojson)
- [Credits](#credits)

<!-- /MarkdownTOC -->

## Requirements

Minimum required PHP version is 5.4. PHP 5.3 compatibility was dropped with release of version 0.4.

## Documentation

The documentation is available at https://phpgeo.marcusjaschen.de/

API documentation is available as well: https://phpgeo.marcusjaschen.de/api/

## Installation

Using [Composer](https://getcomposer.org), just add it to your `composer.json` by running:

```
composer require mjaschen/phpgeo
```

## Features

**Info:** Please visit the **[documentation site](https://phpgeo.marcusjaschen.de/)** for complete and up-to-date documentation!

phpgeo provides the following features (follow the links for examples):

- abstractions of several geometry objects ([coordinate/point](https://phpgeo.marcusjaschen.de/geometry/coordinate/),
  [line](https://phpgeo.marcusjaschen.de/geometry/line/),
  [polyline/GPS track](https://phpgeo.marcusjaschen.de/geometry/polyline/),
  [polygon](https://phpgeo.marcusjaschen.de/geometry/polygon/)
- support for different [ellipsoids](https://phpgeo.marcusjaschen.de/geometry/ellipsoid/), e. g. WGS-84
- [length/distance/perimeter calculations](https://phpgeo.marcusjaschen.de/calculations/distance/)
  with different implementations (Haversine, Vincenty)
- [Geofence](https://phpgeo.marcusjaschen.de/calculations/geofence/) calculation,
  i. e. answering the question "Is this point contained in that area/polygon?"
- [formatting and output](https://phpgeo.marcusjaschen.de/formatting/) of geometry objects
  (GeoJSON, nice strings, e. g. `18° 54′ 41″ -155° 40′ 42″`)
- calculation of [bearing angle between two points](https://phpgeo.marcusjaschen.de/calculations/bearing/#bearing-between-two-points)
  (spherical or with Vincenty's formula)
- calculation of a [destination point for a given starting point](https://phpgeo.marcusjaschen.de/calculations/bearing/#destination-point-for-given-bearing-and-distance),
  bearing angle, and distance (spherical or with Vincenty's formula)
- calculation of the [perpendicular distance between a point and a line](https://phpgeo.marcusjaschen.de/#_perpendicular_distance)
- getting segments of a [polyline](https://phpgeo.marcusjaschen.de/geometry/polyline/#segments)
  /[polygon](https://phpgeo.marcusjaschen.de/geometry/polygon/#segments),
- [reversing direction](https://phpgeo.marcusjaschen.de/geometry/polyline/#reverse-direction) 
  of polyline/polygon

## Examples/Usage

This list is incomplete, please visit the [documentation site](https://phpgeo.marcusjaschen.de/)
for the full monty of documentation and examples!

### Distance between two coordinates (Vincenty's Formula)

Use the calculator object directly:

```php
<?php

use Location\Coordinate;
use Location\Distance\Vincenty;

$coordinate1 = new Coordinate(19.820664, -155.468066); // Mauna Kea Summit
$coordinate2 = new Coordinate(20.709722, -156.253333); // Haleakala Summit

$calculator = new Vincenty();

echo $calculator->getDistance($coordinate1, $coordinate2); // returns 128130.850 (meters; ≈128 kilometers)
```

or call the `getDistance()` method of a Coordinate object by injecting a calculator object:

```php
<?php

use Location\Coordinate;
use Location\Distance\Vincenty;

$coordinate1 = new Coordinate(19.820664, -155.468066); // Mauna Kea Summit
$coordinate2 = new Coordinate(20.709722, -156.253333); // Haleakala Summit

echo $coordinate1->getDistance($coordinate2, new Vincenty()); // returns 128130.850 (meters; ≈128 kilometers)
```

### Simplifying a polyline

Polylines can be simplified to save storage space or bandwidth. Simplification is done with the [Ramer–Douglas–Peucker algorithm](https://en.wikipedia.org/wiki/Ramer–Douglas–Peucker_algorithm) (AKA Douglas-Peucker algorithm).

```php
<?php

use Location\Coordinate;
use Location\Polyline;
use Location\Distance\Vincenty;

$polyline = new Polyline();
$polyline->addPoint(new Coordinate(10.0, 10.0));
$polyline->addPoint(new Coordinate(20.0, 20.0));
$polyline->addPoint(new Coordinate(30.0, 10.0));

$processor = new Simplify($polyline);

// remove all points which perpendicular distance is less
// than 1500 km from the surrounding points.
$simplified = $processor->simplify(1500000);

// simplified is the polyline without the second point (which
// perpendicular distance is ~1046 km and therefore below
// the simplification threshold)
```

### Polygon contains a point (e.g. "GPS geofence")

phpgeo has a polygon implementation which can be used to determinate if a point is contained in it or not.
A polygon consists of at least three points. Points are instances of the `Coordinate` class.

**Warning:** The calculation gives wrong results if the polygons has points on both sides of the 180/-180 degrees meridian.

```php
<?php

use Location\Coordinate;
use Location\Polygon;

$geofence = new Polygon();

$geofence->addPoint(new Coordinate(-12.085870,-77.016261));
$geofence->addPoint(new Coordinate(-12.086373,-77.033813));
$geofence->addPoint(new Coordinate(-12.102823,-77.030938));
$geofence->addPoint(new Coordinate(-12.098669,-77.006476));

$outsidePoint = new Coordinate(-12.075452, -76.985079);
$insidePoint = new Coordinate(-12.092542, -77.021540);

var_dump($geofence->contains($outsidePoint)); // returns bool(false) the point is outside the polygon
var_dump($geofence->contains($insidePoint)); // returns bool(true) the point is inside the polygon
```

### Formatted output of coordinates

You can format a coordinate in different styles.

#### Decimal Degrees

```php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalDegrees;

$coordinate = new Coordinate(19.820664, -155.468066); // Mauna Kea Summit

echo $coordinate->format(new DecimalDegrees());
```

#### Degrees/Minutes/Seconds (DMS)

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

#### GeoJSON

```php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\GeoJSON;

$coordinate = new Coordinate(18.911306, -155.678268); // South Point, HI, USA

echo $coordinate->format(new GeoJSON()); // { "type" : "point" , "coordinates" : [ -155.678268, 18.911306 ] }
```


## Credits

* Marcus Jaschen <mail@marcusjaschen.de>
* [Chris Veness](http://www.movable-type.co.uk/scripts/latlong-vincenty.html) - JavaScript implementation of the [Vincenty formula](http://en.wikipedia.org/wiki/Vincenty%27s_formulae) for distance calculation
* Ersts,P.J., Horning, N., and M. Polin[Internet] Perpendicular Distance Calculator(version 1.2.2) [Documentation](http://biodiversityinformatics.amnh.org/open_source/pdc/documentation.php). American Museum of Natural History, Center for Biodiversity and Conservation. Available from http://biodiversityinformatics.amnh.org/open_source/pdc. Accessed on 2013-07-07.
* W. Randolph Franklin, PNPOLY - Point Inclusion in Polygon Test [Documentation](http://www.ecse.rpi.edu/Homepages/wrf/Research/Short_Notes/pnpoly.html)
* [Richard Barnes](https://github.com/r-barnes) Polyline GeoJSON Formatter
* [Paul Vidal](https://github.com/paulvl) Polygon Implementation

