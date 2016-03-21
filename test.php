<?php

require_once  __DIR__ . '/vendor/autoload.php';

use Location\Coordinate;
use Location\Polygon;
use Location\Formatter\Coordinate\DecimalDegrees;

$polygon = new Polygon();
$polygon->addPoint(new Coordinate(52.5, 13.5));
$polygon->addPoint(new Coordinate(64.1, - 21.9));
$polygon->addPoint(new Coordinate(40.7, - 74.0));
$polygon->addPoint(new Coordinate(33.9, - 118.4));

$reversed = $polygon->getReverse();

foreach ($reversed->getPoints() as $point) {
    echo $point->format(new DecimalDegrees(', ')) . PHP_EOL;
}
