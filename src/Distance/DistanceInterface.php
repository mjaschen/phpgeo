<?php

declare(strict_types=1);

namespace Location\Distance;

use Location\Coordinate;

interface DistanceInterface
{
    /**
     * @return float distance between the two points in meters
     */
    public function getDistance(Coordinate $point1, Coordinate $point2): float;
}
