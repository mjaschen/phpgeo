# Bounds

Bounds describe an area which is defined by its north-eastern and south-western points.

All of *phpgeo's* geometries except for the `Coordindate` class provide a `getBounds()` method via the `GeoBoundsTrait`.

The `Bounds` class has a method to calculate the center point of the bounds object (works correctly for bounds that cross the dateline at 180/-180 degrees longitude too).
