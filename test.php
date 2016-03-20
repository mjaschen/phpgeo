<?php

require_once __DIR__ . '/vendor/autoload.php';

use Location\Ellipsoid;

$ellipsoid = new Ellipsoid('GRS-80', 6378137, 298.257222);

printf(
    "%s: a=%f; b=%f; 1/f=%f \n",
    $ellipsoid->getName(),
    $ellipsoid->getA(),
    $ellipsoid->getB(),
    $ellipsoid->getF()
);

$ellipsoid = Ellipsoid::createDefault('WGS-84');

printf(
    "%s: a=%f; b=%f; 1/f=%f \n",
    $ellipsoid->getName(),
    $ellipsoid->getA(),
    $ellipsoid->getB(),
    $ellipsoid->getF()
);
