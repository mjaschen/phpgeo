# Coordinates

The `Coordinate` class is the most important part of phpgeo and provides the
base for all features.

It's a representation of a geographic location and consists of three parts:

- Geographic Latitude
- Geographic Longitude
- Ellipsoid

Geographic latitude and longitude values are float numbers between
-90.0 and 90.0 (latitude) and -180.0 and 180.0 (longitude).

The Ellipsoid is a representation of an approximated shape of the earth and
is abstracted in its own [Ellipsoid](ellipsoid.md) class.

## Creation

The geographic latitude and longitude is passed as float values to the
constructor of the `Coordinate` class. The constructor supports an
`Ellipsoid` instance as optional third argument. If the ellipsoid argument
is omitted, *WGS-84* will be used as default.

```php
use Location\Coordinate;

$point = new Coordinate(52.5, 13.5);

printf("latitude: %.4f, longitude: %.4f\n", $point->getLat(), $point->getLng());
```

The code above will produce the output below:

```
latitude: 52.5000, longitude: 13.5000
```
