# Change Log

All notable changes to `mjaschen/phpgeo` will be documented in this file.
Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

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
