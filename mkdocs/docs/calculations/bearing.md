# Bearing and Destination

phpgeo can be used to calculate the bearing between two points and to
get a destination point for a given start point together with a bearing
angle and a distance.

Multiple calculation algorithms are supported. Currently phpgeo provides
methods for calculations with a spherical earth model and with an ellipsoidal
model. The spherical calculations are very fast, compared to the ellipsoidal
methods. The ellipsoidal algorithms are a bit more precise on the other hand.

## Bearing between two points

Given two points, it's possible to calculate the bearing angled between 
those points.

phpgeo can calculate the initial bearing (bearing as seen from the first
point) and the final bearing (bearing as seen approaching the destination
point).

### Calculation with a spherical earth model

```php
<?php

use Location\Bearing\BearingSpherical;
use Location\Coordinate;

$berlin = new Coordinate(52.5, 13.5);
$london = new Coordinate(51.5, -0.12);

$bearingCalculator = new BearingSpherical();

var_dump($bearingCalculator->calculateBearing($berlin, $london));
```

The code above will produce the following output:

```
float(268.60722336693)
```

### Calculation with an ellipsoidal earth model

```php
<?php

use Location\Bearing\BearingEllipsoidal;
use Location\Coordinate;

$berlin = new Coordinate(52.5, 13.5);
$london = new Coordinate(51.5, -0.12);

$bearingCalculator = new BearingEllipsoidal();

var_dump($bearingCalculator->calculateBearing($berlin, $london));
```

The code above will produce the following output:

```
float(268.62436347111)
```

## Destination point for given bearing and distance

E. g. starting from Berlin, calculate the destination point in 56.1 km distance
with an initial bearing of 153 degrees:

```php
<?php
use Location\Bearing\BearingEllipsoidal;
use Location\Bearing\BearingSpherical;
use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalDegrees;

$berlin = new Coordinate(52.5, 13.5);

$bearingSpherical = new BearingSpherical();
$bearingEllipsoidal = new BearingEllipsoidal();

$destination1 = $BearingSpherical->calculateDestination($berlin, 153, 56100);
$destination2 = $bearingEllipsoidal->calculateDestination($berlin, 153, 56100);

echo "Spherical:   " . $destination1->format(new DecimalDegrees()) . PHP_EOL;
echo "Ellipsoidal: " . $destination2->format(new DecimalDegrees()) . PHP_EOL;
```

The code above will produce the output below:

    Spherical:   52.04988 13.87628
    Ellipsoidal: 52.05020 13.87126

Oh, look, what a [beautiful spot on earth](http://www.openstreetmap.org/?mlat=52.0499&mlon=13.8762#map=13/52.0499/13.8762) it is. ;-)

## Final Bearing for a calculated destination 

phpgeo can calculate the final bearing angle for a given starting point,
an initial bearing, and the distance to the destination.

```php
<?php
use Location\Bearing\BearingEllipsoidal;
use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalDegrees;

$berlin = new Coordinate(52.5, 13.5);

$bearingEllipsoidal = new BearingEllipsoidal();

$finalBearing = $bearingEllipsoidal->calculateDestinationFinalBearing($berlin, 153, 56100);

var_dump($finalBearing);
```

The code above will produce the output below:

    float(153.29365182147)
