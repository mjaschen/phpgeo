# Coordinate

The `Coordinate` class is the most important class of phpgeo and provides the
base for all features. It's a representation of a geographic location and
consists of three parts:

- Geographic Latitude
- Geographic Longitude
- Ellipsoid

Geographic latitude and longitude values are float numbers between
-90.0 and 90.0 (degrees latitude) and -180.0 and 180.0 (degrees longitude).

The Ellipsoid is a representation of an approximated shape of the earth and
is abstracted in its own [`Ellipsoid`](Ellipsoid) Link class.
