**Table of Contents**

- [phpgeo - A Simple Geo Library for PHP](#phpgeo---a-simple-geo-library-for-php)
	- [Installation](#installation)
	- [Usage](#usage)
		- [Calculations](#calculations)
			- [Distance between two coordinates (Vincenty's Formula)](#distance-between-two-coordinates-vincenty's-formula)
			- [Distance between two coordinates (Haversine Formula)](#distance-between-two-coordinates-haversine-formula)
			- [Length of a polyline (e.g. "GPS track")](#length-of-a-polyline-eg-gps-track)
			- [Simplifying a polyline](#simplifying-a-polyline)
		- [Formatted output of coordinates](#formatted-output-of-coordinates)
			- [Decimal Degrees](#decimal-degrees)
			- [Degrees/Minutes/Seconds (DMS)](#degreesminutesseconds-dms)
			- [GeoJSON](#geojson)
	- [Credits](#credits)

# phpgeo - A Simple Geo Library for PHP

[![Build Status](https://travis-ci.org/mjaschen/phpgeo.png?branch=master)](https://travis-ci.org/mjaschen/phpgeo)

phpgeo provides abstractions to geographical coordinates (including support for different ellipsoids) and allows you to calculate geographical distances between coordinates with high precision.

## Installation

Using Composer, just add the following configuration to your `composer.json`:

```json
{
    "require": {
        "mjaschen/phpgeo": "*"
    }
}
```

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

Polylines can be simplified to save storage space. Simplification is done with the [Ramer–Douglas–Peucker algorithm](https://en.wikipedia.org/wiki/Ramer–Douglas–Peucker_algorithm) (AKA Douglas-Peucker algorithm).

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

echo $coordinate->format(new GeoJSON()); // { "type" : "point" , "coordinates" : [ 18.911306, -155.678268 ] }
```

## Credits

* Marcus T. Jaschen <mjaschen@gmail.com>
* [Chris Veness](http://www.movable-type.co.uk/scripts/latlong-vincenty.html) - JavaScript implementation of the [Vincenty formula](http://en.wikipedia.org/wiki/Vincenty%27s_formulae) for distance calculation
* Ersts,P.J., Horning, N., and M. Polin[Internet] Perpendicular Distance Calculator(version 1.2.2) [Documentation](http://biodiversityinformatics.amnh.org/open_source/pdc/documentation.php). American Museum of Natural History, Center for Biodiversity and Conservation. Available from http://biodiversityinformatics.amnh.org/open_source/pdc. Accessed on 2013-07-07.
