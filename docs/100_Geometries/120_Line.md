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
