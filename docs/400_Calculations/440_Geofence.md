# Geofence

_phpgeo_ has a polygon implementation which can be used to determinate
if a geometry (point, line, polyline, polygon) is contained in it or not.
A polygon consists of at least three points.

WARNING: The calculation gives wrong results if the polygons crosses
the 180/-180 degrees meridian.

``` php
<?php

use Location\Coordinate;
use Location\Polygon;

$geofence = new Polygon();

$geofence->addPoint(new Coordinate(-12.085870,-77.016261));
$geofence->addPoint(new Coordinate(-12.086373,-77.033813));
$geofence->addPoint(new Coordinate(-12.102823,-77.030938));
$geofence->addPoint(new Coordinate(-12.098669,-77.006476));

$outsidePoint = new Coordinate(-12.075452, -76.985079);
$insidePoint = new Coordinate(-12.092542, -77.021540);

echo $geofence->contains($outsidePoint)
    ? 'Point 1 is located inside the polygon' . PHP_EOL
    : 'Point 1 is located outside the polygon' . PHP_EOL;

echo $geofence->contains($insidePoint)
    ? 'Point 2 is located inside the polygon' . PHP_EOL
    : 'Point 2 is located outside the polygon' . PHP_EOL;
```

The code above will produce the output below:

``` plaintext
Point 1 is located outside the polygon
Point 2 is located inside the polygon
```
