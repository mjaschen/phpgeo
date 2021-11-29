# Change Log

All notable changes to `mjaschen/phpgeo` will be documented in this file.
Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [4.0.0] - 2021-11-29

### Changed

- drop support for PHP 7.2 **breaking change**
- add support for PHP 8.1
- add deprecations for setter methods in `DMS` and `Line` classes

## [3.2.1] - 2021-03-04

### Fixed

- Division by zero in `SimplifyBearing` if two consecutive points share the same location, fixes #79.

## [3.2.0] - 2020-10-09

### Added

- Calculation of [Cardinal Distances](https://phpgeo.marcusjaschen.de/Calculations/Cardinal_Distance.html) between two points. Thanks @LeoVie!

### Changed

- change `static` to `self` to prevent accidentally calling the constructor with wrong arguments in child classes (`Ellipsoid`, `Line`, `Polygon`, `Polyline`)

## [3.1.0] - 2020-07-24

### Added

- Simplifying polygons is now supported as well, see `simplifyGeometry()` methods in `SimplifyBearing` and `SimplifyDouglasPeucker` classes (fixes #69).

## [3.0.1] - 2020-05-18

### Fixed

- \#68 `CoordinateFactory` emitted a warning if a coordindates string without arc seconds was passed to the `fromString()` method

## [3.0.0] - 2020-02-07

### Changed

- *phpgeo* requires PHP >= 7.2 now
- **backwards compatibility breaking:** fix double space in Ellipsoid Name `World␣Geodetic␣System␣␣1984` → `World␣Geodetic␣System␣1984` (#49)
- updated tests for PHPUnit 8

### Added

- class constant visibiliy modifiers

### Removed

- support for PHP 7.0 and PHP 7.1 from Travis CI config

## [2.6.0] - 2020-02-05

### Added

- method `getIntermediatePoint()` to the `Line` class which calculates an intermediate point on a line by following the Great Circle between the two line ends and dividing the line by the given fraction (0.0 ... 1.0)

## [2.5.0] - 2020-02-04

### Added

- method `getMidpoint()` to the `Line` class which calculates the midpoint of a line by following the Great Circle between the two line ends and dividing the line into two halves.
- utility class `Cartesian` which abstracts three-dimensional cartesian coordinates *x*, *y*, and *z*

## [2.4.1] - 2020-01-29

### Changed

- access modifier for the `tolerance` attribute is now protected (`SimplifyDouglasPeucker`)

## [2.4.0] - 2020-01-27

### Added

- `BoundsFactory` to create a bounds instance for a center point and a given distance to the bounds' corners. Thanks @sdennler!

## [2.3.1] - 2019-12-21

### Fixed

- improve precision in `PointToLineDistance`

## [2.3.0] - 2019-12-19

### Added

- `PointToLineDistance` calculates the smallest distance between a point and a line

## [2.2.0] - 2019-11-25

### Added

- `hasSameLocation()` checks if two points share the same location (optionally within a distance which defaults to 0.001 m = 1 mm)
- `addUniquePoint` adds unique points to a polyline (i.e., points that doesn't already exist in that polyline)
- `getAveragePoint()` returns the average value of latitude and longitude values for a polyline

### Fixed

- wrongly placed parenthesis in `Polygon::contains()`

## [2.1.0] - 2019-03-22

### Added

- The bounds for a `Polyline` can now be retrieved in form of a `Bound` object.

### Changed

- The auto-loader is now PSR-4 compatible; directory structure was flattened by one level.

## [2.0.5] - 2019-02-27

### Changed

- improvements to the Douglas-Peucker processor. Thanks @iamskey!

## [2.0.3] - 2018-07-19

### Fixed

- Links to documentation in README. Thanks @JonathanMH

### Changed

- better floating point number comparisons in `Vincenty`
- add exception message in `Vincenty`
- type-cast regexp matches before doing calculations in `CoordinateFactory`

## [2.0.2] - 2018-03-27

### Added

- Information on how to run checks and tests for developers in the README.

### Changed

- Updated internal stuff like type and return hints after running a static analysis.
- Updated some PHPDoc blocks after running a static analysis.

### Fixed

- Wrongly typed return value in `BearingEllipsoidal::inverseVincenty()`.

## [2.0.1] - 2018-02-16

### Added

- new supported format for coordinates parser. Thanks to @petrknap

## [2.0.0] - 2017-09-27

### Changed

* License: *phpgeo* is now distributed under the MIT license
* phpgeo requires at least PHP 7.0

### Removed

* deprecated class `Simplify` was removed; alternatives: `SimplifyBearing` or `SimplifyDouglasPeucker`
* PHP versions 5.4, 5.5, and 5.6 are no longer supported

## [1.3.8] - 2017-07-05

### Fixed

* Area calculation for polygons works now. Thanks to @felixveysseyre

## [1.3.7] - 2017-07-01

### Fixed

* GeoJSON output for polygon is now compliant with RFC 7946. Thanks to @arsonik

## [1.3.5] - 2016-08-19

### Added

* add method for calculating the final bearing for a `Line` object

## [1.3.3] - 2016-08-16

### Fixed

* bugifx for a division-by-zero error which occurred when symplifying a polyline
  with the Douglas-Peucker algorithm.

## [1.3.2] - 2016-03-26

### Added

* add an utility class to calculate the perpendicular distance between a point
  and a line; [documentation](https://phpgeo.marcusjaschen.de/#_perpendicular_distance)

## [1.3.1] - 2016-03-26

### Added

* add method to calculate the bearing of a `Line` instance (point 1 -> point 2)

## [1.3.0] - 2016-03-26

### Added

* A new `SimplifyInterface` was introduced and is implemented in two classes:
  `SimplifyDouglasPeucker` and `SimplifyBearing`
* Added documentation

### Deprecated

* The `Simplify` processor class is now deprecated and will be removed in the
  2.0 release.

## [1.2.1] - 2016-03-15

### Added

* Added functionality to change the direction of Polygon instances
* Added documentation

## [1.2.0] - 2016-03-14

### Added

* Added geofence check for arbitrary geometry objects
* Extended and updated documentation

## [1.1.1] - 2016-03-13

### Added

* Added formatter for "Decimal Minutes" format, e.g. `43° 37.386' N, 070° 12.472' W`
* Added documentation for the new formatter

## [1.1.0] - 2016-03-12

### Added

* Added calculation of the bearing angle between two points (initial and final bearing)
* Added calculation of the destination point for a given starting point, the bearing angle, and the distance
* Support for spherical and ellipsoidal algorithms for the described bearing calculations
* Added documentation for the bearing calculations

## [1.0.4] - 2016-03-11

### Added

* Added functionality to change the direction of Line/Polyline instances
* Added documentation

## [1.0.3] - 2016-03-10

### Added

* Added documentation sources in mkdocs format. Documentation is now available online at http://phpgeo.marcusjaschen.de/

## [1.0.2] - 2016-03-04

### Changed

* several optimizations in control structures

## [1.0.0] - 2016-02-11

### Added

* Added license information. *phpgeo* is now licensed under the GPL 3. (see issue [#8](https://github.com/mjaschen/phpgeo/issues/8))

## [0.4.0] - 2015-10-29

### Deprecated

* removed support for PHP 5.3; introduced short array syntax

## [0.3.0] - 2015-10-29

### Added

* added the new Polyline class (thanks [@paulvl](https://github.com/paulvl))
