# phpgeo - A Simple Geo Library for PHP

phpgeo provides abstractions to geographical coordinates (including support for different ellipsoids) and allows you to calculate geographical distances between coordinates with high precision.

## Installation

Using Composer, just add the following configuration to your `composer.json`:

    {
        "require": {
            "mjaschen/phpgeo": "*"
        }
    }

## Usage

### Distance between two coordinates

    use Location\Coordinate;
    use Location\Distance\Vincenty;

    $coordinate1 = new Coordinate(19.820664, -155.468066); // Mauna Kea Summit
    $coordinate2 = new Coordinate(20.709722, -156.253333); // Haleakala Summit

    $calculator = new Vincenty();
    $distance = $calculator->getDistance($coordinate1, $coordinate2); // returns 128130.850 (meters; ≈128 kilometers)

## Credits

* Marcus T. Jaschen <mjaschen@gmail.com>
* [Chris Veness](http://www.movable-type.co.uk/scripts/latlong-vincenty.html) - JavaScript implementation of the [Vincenty formula](http://en.wikipedia.org/wiki/Vincenty%27s_formulae) for distance calculation