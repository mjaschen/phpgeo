# Polyline

[TOC]

A polyline consists of an ordered list of locations, i. e. instances of
the `Coordinate` class.

## Create a polyline

To create a polyline, just instantiate the class and add points:

``` php
<?php

use Location\Coordinate;
use Location\Polyline;

$polyline = new Polyline();
$polyline->addPoint(new Coordinate(52.5, 13.5));
$polyline->addPoint(new Coordinate(54.5, 12.5));
$polyline->addPoint(new Coordinate(55.5, 14.5));
?>
```

It's possible to add points to the end of the polyline at every time with the `addPoint()` method.

Use `addUniquePoint()` to add unique points, i.e. points which doesn't exist already in the polyline.

## Segments

It's possible to get a list of polyline segments. Segments are returned as an
array of `Line` instances.

``` php
<?php

use Location\Coordinate;
use Location\Polyline;

$track = new Polyline();
$track->addPoint(new Coordinate(52.5, 13.5));
$track->addPoint(new Coordinate(54.5, 12.5));
$track->addPoint(new Coordinate(55.5, 14.5));

foreach ($track->getSegments() as $segment) {
    printf(
        "Segment length: %0.2f kilometers\n",
        ($segment->getLength(new Haversine()) / 1000)
    );
}
```

The code above will produce the output below:

``` plaintext
Segment length: 232.01 kilometers
Segment length: 169.21 kilometers
```

## Length

Length calculation is described in the [Distance and Length](../Calculations/Distance_and_Length) section.

## Average Point

The `getAveragePoint()` method returns a point which latitude and longitude is the average of latitude/longitude values from all polyline points.

CAUTION: This method currently returns wrong values if the polyline crosses the date line at 180/-180 degrees longitude.

## Reverse Direction

It's possible to get a new instance with reversed direction while the
original polyline stays unchanged:

``` php
<?php

use Location\Coordinate;
use Location\Polyline;

$track = new Polyline();
$track->addPoint(new Coordinate(52.5, 13.5));
$track->addPoint(new Coordinate(54.5, 12.5));

$reversed = $track->getReverse();

print_r($reversed);
```

The code above will produce the output below:

``` plaintext
Location\Polyline Object
(
    [points:protected] => Array
        (
            [0] => Location\Coordinate Object
                (
                    [lat:protected] => 54.5
                    [lng:protected] => 12.5
                    [ellipsoid:protected] => Location\Ellipsoid Object
                        (
                            [name:protected] => WGS-84
                            [a:protected] => 6378137
                            [f:protected] => 298.257223563
                        )

                )

            [1] => Location\Coordinate Object
                (
                    [lat:protected] => 52.5
                    [lng:protected] => 13.5
                    [ellipsoid:protected] => Location\Ellipsoid Object
                        (
                            [name:protected] => WGS-84
                            [a:protected] => 6378137
                            [f:protected] => 298.257223563
                        )

                )

        )

)
```
