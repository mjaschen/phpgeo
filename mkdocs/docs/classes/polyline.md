# Polyline

A polyline consists of an ordered list of locations, i. e. instances of the `Coordinate` class.

## Segments

It's possible to get a list of polyline segments. Segments are returned as an array of `Line` instances.

```php
<?php

use Location\Coordinate;
use Location\Polyline;

$track = new Polyline();
$track->addPoint(new Coordinate(52.5, 13.5));
$track->addPoint(new Coordinate(54.5, 12.5));
$track->addPoint(new Coordinate(55.5, 14.5));

print_r($track->getSegments());
```

will output:

```
Array
(
    [0] => Location\Line Object
        (
            [point1:protected] => Location\Coordinate Object
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

            [point2:protected] => Location\Coordinate Object
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

        )

    [1] => Location\Line Object
        (
            [point1:protected] => Location\Coordinate Object
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

            [point2:protected] => Location\Coordinate Object
                (
                    [lat:protected] => 55.5
                    [lng:protected] => 14.5
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

## Length

Length calculation is described in the [distance calculations section](/calculations/distance.md#length-of-a-polyline).

## Reverse Direction

It's possible to get a new instance with reversed direction while the original polyline stays unchanged:

```php
<?php

use Location\Coordinate;
use Location\Polyline;

$track = new Polyline();
$track->addPoint(new Coordinate(52.5, 13.5));
$track->addPoint(new Coordinate(54.5, 12.5));

print_r($track->getReverse());
```

will output:

```
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
