## Intersection Checking

It's possible to check if two geometries intersect each other.

(Until this documentation page is finished, take a look into `IntersectionTest` – here you'll find some examples on how to use this feature.)

The following combinations of geometries can be checked for intersection:

|          | Point               | Line | Polyline | Polygon |
|----------|---------------------|------|----------|---------|
| Point    | yes (same location) | no   | no       | yes     |
| Line     | no                  | yes  | yes      | yes     |
| Polyline | no                  | yes  | yes      | yes     |
| Polygon  | yes                 | yes  | yes      | yes     |
