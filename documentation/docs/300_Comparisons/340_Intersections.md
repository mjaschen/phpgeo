## Intersection Checking

The `Intersection` helper checks whether two geometries intersect. It supports
polygons, polylines, and lines, plus point-in-polygon checks.

Basic usage:

```php
use Location\Coordinate;
use Location\Intersection\Intersection;
use Location\Line;
use Location\Polygon;

$intersection = new Intersection();

$line = new Line(
    new Coordinate(52.237594, 9.287635),
    new Coordinate(52.258154, 11.010313)
);

$polygon = new Polygon();
$polygon->addPoint(new Coordinate(52.56571, 9.998658));
$polygon->addPoint(new Coordinate(52.369576, 9.560167));
$polygon->addPoint(new Coordinate(52.102252, 9.62397));
$polygon->addPoint(new Coordinate(51.983342, 10.132727));
$polygon->addPoint(new Coordinate(52.083498, 10.699142));
$polygon->addPoint(new Coordinate(52.457087, 10.590607));
$polygon->addPoint(new Coordinate(52.56571, 9.998658));

// Fast check: bounds intersection only (may return false positives).
$intersects = $intersection->intersects($line, $polygon, false);

// Precise check: segment intersections + containment.
$intersectsPrecisely = $intersection->intersects($line, $polygon, true);
```

Point-in-polygon is also supported:

```php
use Location\Coordinate;
use Location\Intersection\Intersection;
use Location\Polygon;

$intersection = new Intersection();
$point = new Coordinate(52.328745, 10.151638);
$intersects = $intersection->intersects($point, $polygon, true);
```

For point-to-point comparisons, use `Coordinate::hasSameLocation()` or
`Coordinate::intersects()` instead of `Intersection`.

The following combinations of geometries can be checked for intersection:

|          | Point                                                          | Line | Polyline | Polygon                                                   |
|----------|----------------------------------------------------------------|------|----------|-----------------------------------------------------------|
| Point    | yes ([same location](310_Same_Point_Comparison.md))            | no   | no       | yes ([point inside polygon](../400_Calculations/440_Geofence.md)) |
| Line     | no                                                             | yes  | yes      | yes                                                       |
| Polyline | no                                                             | yes  | yes      | yes                                                       |
| Polygon  | yes ([point inside polygon](../400_Calculations/440_Geofence.md)) | yes  | yes      | yes                                                       |

### Precision modes

`Intersection::intersects()` accepts a third parameter that controls precision:

- `false` (default) checks only the geometries' bounds. This is fast but can
  produce false positives when bounds overlap but shapes do not.
- `true` checks each segment for intersection and also checks polygon
  containment. This is slower but accurate for supported geometries.

If you pass unsupported combinations (for example, point-to-line), an
`InvalidGeometryException` is thrown.
