**Table of Contents**

- [phpgeo - A Simple Geo Library for PHP](#phpgeo---a-simple-geo-library-for-php)
    - [Installation](#installation)
	- [Changelog](#changelog)
	- [Usage](#usage)
		- [Calculations](#calculations)
			- [Distance between two coordinates (Vincenty's Formula)](#distance-between-two-coordinates-vincenty's-formula)
			- [Distance between two coordinates (Haversine Formula)](#distance-between-two-coordinates-haversine-formula)
			- [Length of a polyline (e.g. "GPS track")](#length-of-a-polyline-eg-gps-track)
			- [Perimeter of a Polygon](#perimeter-of-a-polygon)
            - [Polygon contains a point (e.g. "GPS geofence")](#polygon-contains-a-point-eg-gps-geofence)
			- [Simplifying a polyline](#simplifying-a-polyline)
		- [Formatted output of coordinates](#formatted-output-of-coordinates)
			- [Decimal Degrees](#decimal-degrees)
			- [Degrees/Minutes/Seconds (DMS)](#degreesminutesseconds-dms)
			- [GeoJSON](#geojson)
		- [Formatted output of polylines](#formatted-output-of-polylines)
			- [GeoJSON](#geojson-1)
		- [Formatted output of polygons](#formatted-output-of-polygons)
			- [GeoJSON](#geojson-1)
	- [Credits](#credits)

# phpgeo - A Simple Geo Library for PHP

[![Build Status](https://img.shields.io/travis/mjaschen/phpgeo.svg?style=flat-square)](https://travis-ci.org/mjaschen/phpgeo) [![Latest Stable Version](https://img.shields.io/packagist/v/mjaschen/phpgeo.svg?style=flat-square)](https://packagist.org/packages/mjaschen/phpgeo) [![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/mjaschen/phpgeo.svg?style=flat-square)](https://scrutinizer-ci.com/g/mjaschen/phpgeo/?branch=master)

phpgeo provides abstractions to geographical coordinates (including support for different ellipsoids) and allows you to calculate geographical distances between coordinates with high precision.

PHP 5.3 compatibility will be dropped with release of version 0.4.

## Installation

Using [Composer](https://getcomposer.org), just add it to your `composer.json` by running:

```
composer require mjaschen/phpgeo
```

## Changelog

### Version 0.3

- added Polyline class (thanks @paulvl)

## Usage

### Calculations

#### Distance between two coordinates (Vincenty's Formula)

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

#### Distance between two coordinates (Haversine Formula)

There exist different methods for calculating the distance between two points. The [Haversine formula](http://en.wikipedia.org/wiki/Law_of_haversines) is much faster the Vincenty's method but less precise:

```php
<?php

use Location\Coordinate;
use Location\Distance\Haversine;

$coordinate1 = new Coordinate(19.820664, -155.468066); // Mauna Kea Summit
$coordinate2 = new Coordinate(20.709722, -156.253333); // Haleakala Summit

echo $coordinate1->getDistance($coordinate2, new Haversine()); // returns 128384.515 (meters; ≈128 kilometers)
```

#### Length of a polyline (e.g. "GPS track")

phpgeo has a polyline implementation which can be used to calculate the length of a GPS track or a route. A polyline consists of at least two points. Points are instances of the `Coordinate` class.

```php
<?php

use Location\Coordinate;
use Location\Polyline;
use Location\Distance\Vincenty;

$track = new Polyline();
$track->addPoint(new Coordinate(52.5, 13.5));
$track->addPoint(new Coordinate(54.5, 12.5));

echo $track->getLength(new Vincenty());
```

#### Simplifying a polyline

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

#### Perimeter of a Polygon

The perimeter is calculated as the sum of the length of all segments. The result is given in meters.

```php
<?php

use Location\Distance\Vincenty;
use Location\Coordinate;
use Location\Polygon;

$polygon = new Polygon();
$polygon->addPoint(new Coordinate(10, 10));
$polygon->addPoint(new Coordinate(10, 20));
$polygon->addPoint(new Coordinate(20, 20));
$polygon->addPoint(new Coordinate(20, 10));

echo $polygon->getPerimeter(new Vincenty()); // 4355689.472 (meters)
```

#### Polygon contains a point (e.g. "GPS geofence")

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

### Formatted output of polylines

You can format a polyline in different styles.

#### GeoJSON

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

### Formatted output of polygons

You can format a polygon in different styles.

#### GeoJSON

```php
<?php

use Location\Coordinate;
use Location\Polygon;
use Location\Formatter\Polygon\GeoJSON;

$polygon = new Polygob;
$polygon->addPoint(new Coordinate(10, 20));
$polygon->addPoint(new Coordinate(20, 40));
$polygon->addPoint(new Coordinate(30, 40));
$polygon->addPoint(new Coordinate(30, 20));

$formatter = new GeoJSON;

echo $formatter->format($polygon); // { "type" : "Polygon" , "coordinates" : [ [ 20, 10 ], [ 40, 20 ], [ 40, 30 ], [ 20, 30] ] }
```

## Credits

* Marcus Jaschen <mail@marcusjaschen.de>
* [Chris Veness](http://www.movable-type.co.uk/scripts/latlong-vincenty.html) - JavaScript implementation of the [Vincenty formula](http://en.wikipedia.org/wiki/Vincenty%27s_formulae) for distance calculation
* Ersts,P.J., Horning, N., and M. Polin[Internet] Perpendicular Distance Calculator(version 1.2.2) [Documentation](http://biodiversityinformatics.amnh.org/open_source/pdc/documentation.php). American Museum of Natural History, Center for Biodiversity and Conservation. Available from http://biodiversityinformatics.amnh.org/open_source/pdc. Accessed on 2013-07-07.
* W. Randolph Franklin, PNPOLY - Point Inclusion in Polygon Test [Documentation](http://www.ecse.rpi.edu/Homepages/wrf/Research/Short_Notes/pnpoly.html)
* [Richard Barnes](https://github.com/r-barnes) Polyline GeoJSON Formatter
* [Paul Vidal](https://github.com/paulvl) Polygon Implementation

