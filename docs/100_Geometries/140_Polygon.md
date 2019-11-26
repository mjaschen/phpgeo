# Polygon

[TOC]

A polygon consists of an ordered list of locations, i. e. instances of
the `Coordinate` class. It's very similar to a polyline, but its start
and end points are connected.

## Create a polygon

To create a polygon, just instantiate the class and add points:

``` php
<?php

use Location\Coordinate;
use Location\Polygon;

$polygon = new Polygon();
$polygon->addPoint(new Coordinate(52.5, 13.5));
$polygon->addPoint(new Coordinate(54.5, 12.5));
$polygon->addPoint(new Coordinate(55.5, 14.5));
?>
```

It's possible to add points to the end at every time.

## Get list of points

`getPoints()` is used to get the list of points, the number of points can be
retrieved by calling `getNumberOfPoints()`:

``` php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\DMS;
use Location\Polygon;

$polygon = new Polygon();
$polygon->addPoint(new Coordinate(52.5, 13.5));
$polygon->addPoint(new Coordinate(54.5, 12.5));
$polygon->addPoint(new Coordinate(55.5, 14.5));

printf("The polygon consists of %d points:\n", $polygon->getNumberOfPoints());

foreach ($polygon->getPoints() as $point) {
    echo $point->format(new DMS()) . PHP_EOL;
}
```

The code above will produce the output below:

``` plaintext
The polygon consists of 3 points:
52° 30′ 00″ 013° 30′ 00″
54° 30′ 00″ 012° 30′ 00″
55° 30′ 00″ 014° 30′ 00″
```

## Segments

It's possible to get a list of polygon segments. Segments are
returned as an array of `Line` instances.

``` php
<?php

use Location\Coordinate;
use Location\Distance\Haversine;
use Location\Polygon;

$polygon = new Polygon();
$polygon->addPoint(new Coordinate(52.5, 13.5));
$polygon->addPoint(new Coordinate(54.5, 12.5));
$polygon->addPoint(new Coordinate(55.5, 14.5));

foreach ($polygon->getSegments() as $line) {
    printf("%0.3f m\n", $line->getLength(new Haversine()));
}
```

The code above will produce the output below:

``` plaintext
232011.020 m
169207.795 m
339918.069 m
```

## Length/Perimeter

Length calculation is described in the [Distance and Length](../Calculations/Distance_and_Length) section.

## Area

It's possible to calculate the area of an polygon. The result is given in square meters (m²).

WARNING: The calculation gives inaccurate results. For relatively small polygons the error should be less than 1 %.

``` php
<?php

use Location\Coordinate;
use Location\Polygon;

$formatter = new \Location\Formatter\Coordinate\DecimalDegrees(' ', 10);

$polygon = new Polygon();
$polygon->addPoint(new Coordinate(0.0000000000, 0.0000000000));
$polygon->addPoint(new Coordinate(0.0000000000, 0.0008983153));
$polygon->addPoint(new Coordinate(0.0009043695, 0.0008983153));
$polygon->addPoint(new Coordinate(0.0009043695, 0.0000000000));

printf(
    'Polygon Area = %f m², Perimeter = %f m%s',
    $polygon->getArea(),
    $polygon->getPerimeter(new \Location\Distance\Vincenty()),
    PHP_EOL
);
```

The code above produces the output below:

``` plaintext
Polygon Area = 10044.905261 m², Perimeter = 400.000000 m
```

## Geofence

It's possible to check if a geometry object (point, line, polyline,
polygon) lies inside a polygon. The documentation can be found in
the <<Geofence>> @TODO section.

## Reverse Direction

It's possible to get a new instance with reversed direction while the
original polygon stays unchanged:

``` php
<?php

use Location\Coordinate;
use Location\Polygon;
use Location\Formatter\Coordinate\DecimalDegrees;

$polygon = new Polygon();
$polygon->addPoint(new Coordinate(52.5, 13.5));
$polygon->addPoint(new Coordinate(64.1, - 21.9));
$polygon->addPoint(new Coordinate(40.7, - 74.0));
$polygon->addPoint(new Coordinate(33.9, - 118.4));

$reversed = $polygon->getReverse();

foreach ($reversed->getPoints() as $point) {
    echo $point->format(new DecimalDegrees(', ')) . PHP_EOL;
}
```

The code above produces the output below:

``` plaintext
33.90000, -118.40000
40.70000, -74.00000
64.10000, -21.90000
52.50000, 13.50000
```
