# Upgrading phpgeo

## (not yet released) Update from phpgeo 5.x to phpgeo 6.x

### Update phpgeo

- run `composer require mjaschen/phpgeo:^6.0` or
- update the version constraint in your `composer.json` to `^6.0` and run `composer update`

### Update Your Code

- The `Coordinate` and `CoordinateFactory` classes were removed with phpgeo 6.0. With `Point` and `PointFactory` exist API-compatible drop-in replacements. You have to replace each occurrence of the `\Location\Coordinate` class with `\Location\Point` and each occurrence of `\Location\Factory\CoordinateFactory` with `\Location\Factory\PointFactory`.

## Update from phpgeo 3.x to phpgeo 4.x

### Requirements

- _phpgeo_ 4.x requires at least PHP 7.3 and fully supports PHP 8

### Update phpgeo

- run `composer require mjaschen/phpgeo:^4.0` or
- update the version constraint in your `composer.json` to `^4.0` and run `composer update`

### Update Your Code

- Setters in `DMS` and `Line` classes are deprecated and will be removed
  with the next release. Use constructor arguments instead.

No breaking changes were introduced with *phpgeo* 3.0.

## Update from phpgeo 2.x to phpgeo 3.x

### Requirements

- _phpgeo_ 3.x requires at least PHP 7.2

### Update phpgeo

- run `composer require mjaschen/phpgeo:^3.0` or
- update the version constraint in your `composer.json` to `^3.0` and run `composer update`

### Update Your Code

The result of `Ellipsoid::getName()` for the built-in *WGS-84* ellipsoid returned `World␣Geodetic␣System␣␣1984` in *phpgeo* 2.x (two space characters before `1984`). Starting with *phpgeo* 3.0, the result is `World␣Geodetic␣System␣1984` (single space character before `1984`). Please verify that your code is still working if you're using that result.

Starting with *phpgeo* 3.0 class constant visiblity modifiers are used. One class constant was changed to *private* visibility: `BearingSpherical::EARTH_RADIUS`. Please verify that your code isn't using that class constant.

No further breaking changes were introduced with *phpgeo* 3.0.
