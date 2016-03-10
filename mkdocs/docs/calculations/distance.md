# Distance Calculation

## Distance Between Two Coordinates (Vincenty's Formula)

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

## Distance Between Two Coordinates (Haversine Formula)

There exist different methods for calculating the distance between two points. The [Haversine formula](http://en.wikipedia.org/wiki/Law_of_haversines) is much faster the Vincenty's method but less precise:

```php
<?php

use Location\Coordinate;
use Location\Distance\Haversine;

$coordinate1 = new Coordinate(19.820664, -155.468066); // Mauna Kea Summit
$coordinate2 = new Coordinate(20.709722, -156.253333); // Haleakala Summit

echo $coordinate1->getDistance($coordinate2, new Haversine()); // returns 128384.515 (meters; ≈128 kilometers)
```

## Length of a Polyline

phpgeo has a polyline implementation which can be used to calculate the 
length of a GPS track or a route. A polyline consists of at least two points. 
Points are instances of the `Coordinate` class.

```php
<?php

use Location\Coordinate;
use Location\Polyline;
use Location\Distance\Vincenty;

$track = new Polyline();
$track->addPoint(new Coordinate(52.5, 13.5));
$track->addPoint(new Coordinate(54.5, 12.5));

echo $track->getLength(new Vincenty());
```

#### Perimeter of a Polygon

The perimeter is calculated as the sum of the length of all segments. 
The result is given in meters.

```php
<?php

use Location\Distance\Vincenty;
use Location\Coordinate;
use Location\Polygon;

$polygon = new Polygon();
$polygon->addPoint(new Coordinate(10, 10));
$polygon->addPoint(new Coordinate(10, 20));
$polygon->addPoint(new Coordinate(20, 20));
$polygon->addPoint(new Coordinate(20, 10));

echo $polygon->getPerimeter(new Vincenty()); // 4355689.472 (meters)
```
