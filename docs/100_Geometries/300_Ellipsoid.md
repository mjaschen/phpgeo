# Ellipsoid

An ellipsoid is a mathematically defined approximation of the earth's surface.

An ellipsoid is defined by two parameters:

* the semi-major axis _a_ (equatorial radius)
* the semi-minor axis _b_ (polar radius)

_a_ and _b_ together define the flattening of the ellipsoid _f_:

*f = (a-b) / a*

NOTE: _phpgeo's_ ellipsoids are defined by _a_ and _1/f_ instead of _a_
and _b_. That's not a problem because each of the three values can be
calculated from the other two.

_phpgeo_ supports arbitrary ellipsoids. _WGS-84_ is used as default when
no other ellipsoid is given. For day-to-day calculations it's not needed
to care about ellipsoids in the most cases.

It's possible to create an instance of the Ellipsoid class either by
specifing a name or by providing the three parameters _name,_ _a_, and _1/f_.

``` php
<?php

use Location\Ellipsoid;

$ellipsoid = Ellipsoid::createDefault('WGS-84');

printf(
    "%s: a=%f; b=%f; 1/f=%f\n",
    $ellipsoid->getName(),
    $ellipsoid->getA(),
    $ellipsoid->getB(),
    $ellipsoid->getF()
);

$ellipsoid = new Ellipsoid('GRS-80', 6378137, 298.257222);

printf(
    "%s: a=%f; b=%f; 1/f=%f\n",
    $ellipsoid->getName(),
    $ellipsoid->getA(),
    $ellipsoid->getB(),
    $ellipsoid->getF()
);
```

The first ellipsoid is created from one the the default configurations. The second one is created by providing a name and the values of *a* and *1/f.*

The code above will produce the output below:

``` plaintext
WGS-84: a=6378137.000000; b=6356752.314245; 1/f=298.257224
GRS-80: a=6378137.000000; b=6356752.314133; 1/f=298.257222
```

Please take a look into the [`Ellipsoid` source file](https://github.com/mjaschen/phpgeo/blob/master/src/Ellipsoid.php)
for a list of pre-defined ellipsoids.
