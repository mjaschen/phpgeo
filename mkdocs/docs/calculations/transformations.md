# Transformations

## Simplifying a polyline

Polylines can be simplified to save storage space or bandwidth. Simplification is done with the [Ramer–Douglas–Peucker algorithm](https://en.wikipedia.org/wiki/Ramer–Douglas–Peucker_algorithm) (AKA Douglas-Peucker algorithm).

```php
<?php

use Location\Coordinate;
use Location\Polyline;
use Location\Distance\Vincenty;

$polyline = new Polyline();
$polyline->addPoint(new Coordinate(10.0, 10.0));
$polyline->addPoint(new Coordinate(20.0, 20.0));
$polyline->addPoint(new Coordinate(30.0, 10.0));

$processor = new Simplify($polyline);

// remove all points which perpendicular distance is less
// than 1500 km from the surrounding points.
$simplified = $processor->simplify(1500000);

// simplified is the polyline without the second point (which
// perpendicular distance is ~1046 km and therefore below
// the simplification threshold)
```
