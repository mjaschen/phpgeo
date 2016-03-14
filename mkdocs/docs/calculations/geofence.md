# Geofence - Polygon Contains a Point

phpgeo has a polygon implementation which can be used to determinate if a geometry
(point, line, polyline, polygon) is contained in it or not. A polygon consists of
at least three points.

**Warning:** The calculation gives wrong results if the polygons has points on
both sides of the 180/-180 degrees meridian.

```php
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

var_dump($geofence->contains($outsidePoint)); // returns bool(false) the point is outside the polygon
var_dump($geofence->contains($insidePoint)); // returns bool(true) the point is inside the polygon
```
