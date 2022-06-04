## Intersection Checking

It's possible to check if two geometries intersect each other.

(Until this documentation page is finished, take a look into `IntersectionTest` – here you'll find some examples on how to use this feature.)

The following combinations of geometries can be checked for intersection:

|          | Point                                                          | Line | Polyline | Polygon                                                   |
|----------|----------------------------------------------------------------|------|----------|-----------------------------------------------------------|
| Point    | yes ([same location](/Comparisons/Same_Point_Comparison.html)) | no   | no       | yes ([point inside polygon](/Calculations/Geofence.html)) |
| Line     | no                                                             | yes  | yes      | yes                                                       |
| Polyline | no                                                             | yes  | yes      | yes                                                       |
| Polygon  | yes ([point inside polygon](/Calculations/Geofence.html))      | yes  | yes      | yes                                                       |
