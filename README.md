# phpgeo - A Simple Geo Library for PHP

phpgeo provides abstractions to geographical coordinates (including support for different ellipsoids) and allows you to
calculate geographical distances between coordinates with high precision.

[![Latest Stable Version](https://poser.pugx.org/mjaschen/phpgeo/v)](//packagist.org/packages/mjaschen/phpgeo)
[![Total Downloads](https://poser.pugx.org/mjaschen/phpgeo/downloads)](//packagist.org/packages/mjaschen/phpgeo)
[![phpgeo Tests](https://github.com/mjaschen/phpgeo/actions/workflows/ci.yml/badge.svg)](https://github.com/mjaschen/phpgeo/actions/workflows/ci.yml)
[![Documentation Status](https://github.com/mjaschen/phpgeo/actions/workflows/docs.yml/badge.svg)](https://github.com/mjaschen/phpgeo/actions/workflows/docs.yml)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mjaschen/phpgeo/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mjaschen/phpgeo/?branch=master)
[![License](https://poser.pugx.org/mjaschen/phpgeo/license)](//packagist.org/packages/mjaschen/phpgeo)

## Requirements

Minimum required PHP version is 8.2. *phpgeo* is tested up to PHP 8.4.

New features will only go into the main branch and won't be backported.

It's possible to install older versions of *phpgeo* for older PHP versions.
Please refer to the following table for the compatibility matrix:

| PHP Version | phpgeo Version |  Support Status  | Composer Install                        |
|:-----------:|:--------------:|:----------------:|-----------------------------------------|
|     8.4     |      6.x       |     ✅ active     | `composer require mjaschen/phpgeo`      |
|     8.3     |      6.x       |     ✅ active     | `composer require mjaschen/phpgeo`      |
|     8.2     |      6.x       |     ✅ active     | `composer require mjaschen/phpgeo`      |
|     8.1     |      5.x       | ⚠️ security only | `composer require mjaschen/phpgeo:^5.0` |
|     8.0     |      4.x       | ⚠️ security only | `composer require mjaschen/phpgeo:^4.0` |
|     7.4     |      4.x       | ⚠️ security only | `composer require mjaschen/phpgeo:^4.0` |
|     7.3     |      4.x       | ⚠️ security only | `composer require mjaschen/phpgeo:^4.0` |
|     7.2     |      3.x       |  ❌ end of life   | `composer require mjaschen/phpgeo:^3.0` |
|     7.1     |      2.x       |  ❌ end of life   | `composer require mjaschen/phpgeo:^2.0` |
|     7.0     |      2.x       |  ❌ end of life   | `composer require mjaschen/phpgeo:^2.0` |
|     5.6     |      1.x       |  ❌ end of life   | `composer require mjaschen/phpgeo:^1.0` |
|     5.5     |      1.x       |  ❌ end of life   | `composer require mjaschen/phpgeo:^1.0` |
|     5.4     |      1.x       |  ❌ end of life   | `composer require mjaschen/phpgeo:^1.0` |

## Documentation

The documentation is available at [phpgeo.marcusjaschen.de](https://phpgeo.marcusjaschen.de/).

## Installation

Using [Composer](https://getcomposer.org), just add it to your `composer.json` by running:

```
composer require mjaschen/phpgeo
```

## Upgrading

Update the version constraint in the project's `composer.json` and
run `composer update` or require the new version by running:

```shell
composer require mjaschen/phpgeo:^6.0
```

### Upgrading to 6.x

*phpgeo* has some breaking changes in the 6.x release line. Please refer to the following list to see what has changed
and what you need to do to upgrade your code.

| Change                                                                         | Description                                                   | Action                                                                            |
|--------------------------------------------------------------------------------|---------------------------------------------------------------|-----------------------------------------------------------------------------------|
| `Line`, `Polygon`, and `Polyline` classes are now implementing a new interface | `GeometryLinesInterface` provides the `getSegments()` method. | There's no need to change anything if you don't extend those classes.             |
| `getBounds()` method was added to `GeometryInterface`                          |                                                               | Ensure your class has a `getBounds()` method if you implement `GeometryInterface` |
| removed support for PHP 8.1                                                    | Older PHP versions are no longer supported.                   | Upgrade to at least PHP 8.2 or keep using phpgeo 5.x                              |

### Upgrading to 5.x

*phpgeo* has some breaking changes in the 5.x release line. Please refer to the following list to see what has changed
and what you need to do to upgrade your code.

| Change                                                      | Description                                 | Action                                                  |
|-------------------------------------------------------------|---------------------------------------------|---------------------------------------------------------|
| `setPoint1()` and `setPoint2()` methods removed from `Line` | The `Line` class now is immutable.          | Use the constructor to create a new instance of `Line`. |
| removed support for PHP 7.3, 7.4 and 8.0                    | Older PHP versions are no longer supported. | Upgrade to at least PHP 8.1.                            |

## License

Starting with version 2.0.0 phpgeo is licensed under the MIT license. Older versions were GPL-licensed.

## Features

**Info:** Please visit the **[documentation site](https://phpgeo.marcusjaschen.de/)** for complete and up-to-date
documentation with many examples!

phpgeo provides the following features (follow the links for examples):

- abstractions of several geometry
  objects ([coordinate/point](https://phpgeo.marcusjaschen.de/Geometries/Coordinate.html),
  [line](https://phpgeo.marcusjaschen.de/Geometries/Line.html),
  [polyline/GPS track](https://phpgeo.marcusjaschen.de/Geometries/Polyline.html),
  [polygon](https://phpgeo.marcusjaschen.de/Geometries/Polygon.html)
- support for different [ellipsoids](https://phpgeo.marcusjaschen.de/Geometries/Ellipsoid.html), e.g. WGS-84
- [length/distance/perimeter calculations](https://phpgeo.marcusjaschen.de/Calculations/Distance_and_Length.html)
  with different implementations (Haversine, Vincenty)
- [Geofence](https://phpgeo.marcusjaschen.de/Calculations/Geofence.html) calculation,
  i.e. answering the question "Is this point contained in that area/polygon?" and
  other [intersection](https://phpgeo.marcusjaschen.de/Comparisons/Intersections.html) checks between different
  geometries
- [formatting and output](https://phpgeo.marcusjaschen.de/Formatting_and_Output/index.html) of geometry objects
  (GeoJSON, nice strings, e. g. `18° 54′ 41″ -155° 40′ 42″`)
- calculation
  of [bearing angle between two points](https://phpgeo.marcusjaschen.de/Calculations/Bearing_and_Destination.html#page_Bearing-between-two-points)
  (spherical or with Vincenty's formula)
- calculation of
  a [destination point for a given starting point](https://phpgeo.marcusjaschen.de/Calculations/Bearing_and_Destination.html#page_Destination-point-for-given-bearing-and-distance),
  bearing angle, and distance (spherical or with Vincenty's formula)
- calculation of
  the [perpendicular distance between a point and a line](https://phpgeo.marcusjaschen.de/Calculations/Perpendicular_Distance.html)
- calculation of
  the [Cardinal Distances between two points](https://phpgeo.marcusjaschen.de/Calculations/Cardinal_Distance.html)
- getting segments of a [polyline](https://phpgeo.marcusjaschen.de/Geometries/Polyline.html#page_Segments)
  /[polygon](https://phpgeo.marcusjaschen.de/Geometries/Polygon.html#page_Segments),
- [reversing direction](https://phpgeo.marcusjaschen.de/Geometries/Polygon.html#page_Reverse-Direction)
  of polyline/polygon

## Examples/Usage

This list is incomplete, please visit the **[documentation site](https://phpgeo.marcusjaschen.de/)**
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

Polylines can be simplified to save storage space or bandwidth. Simplification is done with
the [Ramer–Douglas–Peucker algorithm](https://en.wikipedia.org/wiki/Ramer–Douglas–Peucker_algorithm) (AKA
Douglas-Peucker algorithm).

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

**Warning:** The calculation gives wrong results if the polygons has points on both sides of the 180/-180 degrees
meridian.

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

## Development

### Run Tests

Before submitting a pull request, please be sure to run all checks and tests and ensure everything is green.

- lint PHP files for syntax errors: `composer ci:lint`
- run static analysis with [Psalm][] and report errors: `composer ci:psalm`
- run unit tests with PHPUnit: `composer ci:tests`

To run all checks and tests at once, just use `composer ci`.

Of course, it's possible to use the test runners directly, e.g. for PHPUnit:

```shell
./vendor/bin/phpunit
```

PHPStan:

```shell
./vendor/bin/phpstan
```

### Running GitHub Actions locally

It's possible to run the whole CI test matrix locally with *[act](https://github.com/nektos/act)*:

```shell
act --rm -P ubuntu-latest=shivammathur/node:latest
```

## Credits

* Marcus Jaschen <mail@marcusjaschen.de> and [all contributors](https://github.com/mjaschen/phpgeo/graphs/contributors)
* [Chris Veness](http://www.movable-type.co.uk/scripts/latlong-vincenty.html) - JavaScript implementation of
  the [Vincenty formula](http://en.wikipedia.org/wiki/Vincenty%27s_formulae) for distance calculation
* Ersts,P.J., Horning, N., and M. Polin[Internet] Perpendicular Distance Calculator(version
  1.2.2) [Documentation](http://biodiversityinformatics.amnh.org/open_source/pdc/documentation.php). American Museum of
  Natural History, Center for Biodiversity and Conservation. Available
  from http://biodiversityinformatics.amnh.org/open_source/pdc. Accessed on 2013-07-07.
* W. Randolph Franklin, PNPOLY - Point Inclusion in Polygon
  Test [Documentation](http://www.ecse.rpi.edu/Homepages/wrf/Research/Short_Notes/pnpoly.html)
