# Line

[TOC]

A line consists of two points, i. e. instances of the `Coordinate` class.

## Length

The `Line` class provides a method to calculate its own length. The method
expects an instance of a class which implements the `DistanceInterface`.

``` php
<?php

use Location\Coordinate;
use Location\Distance\Haversine;
use Location\Line;

$line = new Line(
    new Coordinate(52.5, 13.5),
    new Coordinate(52.6, 13.4)
);

$length = $line->getLength(new Haversine());

printf("The line has a length of %.3f meters\n", $length);
```

`Haversine` is one of the currently two available classes for
distance calculation. The other one is named `Vincenty`.

The code above will produce the output below:

``` plaintext
The line has a length of 13013.849 meters
```

## Midpoint

The midpoint of a line is calculated by following the Great Circle (defined by the two endpoints) and dividing the line into two halves.

``` php
<?php

declare(strict_types=1);

use Location\Coordinate;
use Location\Distance\Haversine;
use Location\Line;

$line = new Line(
    new Coordinate(35, 45),
    new Coordinate(35, 135)
);

$midpoint = $line->getMidpoint();

printf(
    'The midpoint of the line is located at %.3f degrees latitude and %.3f degrees longitude.%s',
    $midpoint->getLat(),
    $midpoint->getLng(),
    PHP_EOL
);

printf(
    'Its distance from the first point is %.1f meters, its distance from the second point is %.1f meters.%s',
    $line->getPoint1()->getDistance($midpoint, new Haversine()),
    $line->getPoint2()->getDistance($midpoint, new Haversine()),
    PHP_EOL
);
```

## Bearing

The bearing of an instance can be calculated using the `getBearing()` method.
An instance of `BearingInterface` must be provided as method argument.

``` php
<?php

use Location\Bearing\BearingEllipsoidal;
use Location\Coordinate;
use Location\Line;

$line = new Line(
    new Coordinate(52.5, 13.5),
    new Coordinate(52.6, 13.4)
);

$bearing = $line->getBearing(new BearingEllipsoidal());

printf("The line has a bearing of %.2f degrees\n", $bearing);
```

`BearingEllipsoidal` is one of the currently two available classes for
bearing calculation. The other one is named `BearingSpherical`.

The code above will produce the output below:

``` plaintext
The line has a bearing of 328.67 degrees
```

This ist the so called _initial bearing._ There exist another bearing angle,
called the _final bearing._ It can be calculated as well:

``` php
<?php

use Location\Bearing\BearingEllipsoidal;
use Location\Coordinate;
use Location\Line;

$line = new Line(
    new Coordinate(52.5, 13.5),
    new Coordinate(52.6, 13.4)
);

$bearing = $line->getFinalBearing(new BearingEllipsoidal());

printf("The line has a final bearing of %.2f degrees\n", $bearing);
```

The code above will produce the output below:

``` plaintext
The line has a final bearing of 328.59 degrees
```

See Bearing between two points @TODO Link for more information about bearings.
