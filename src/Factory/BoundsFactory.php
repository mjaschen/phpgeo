<?php

declare(strict_types=1);

namespace Location\Factory;

use InvalidArgumentException;
use Location\Bearing\BearingInterface;
use Location\Bounds;
use Location\Coordinate;

class BoundsFactory
{
    /**
     * Creates a Bounds instance which corners have the given distance from its center.
     *
     * @param float $distance in meters
     *
     * @throws InvalidArgumentException if bounds crosses the 180/-180 degrees meridian.
     */
    public static function expandFromCenterCoordinate(
        Coordinate $center,
        float $distance,
        BearingInterface $bearing
    ): Bounds {
        $northWest = $bearing->calculateDestination($center, 315, $distance);
        $southEast = $bearing->calculateDestination($center, 135, $distance);

        return new Bounds($northWest, $southEast);
    }
}
