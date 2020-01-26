<?php

declare(strict_types=1);

namespace Location\Factory;

use Location\Bearing\BearingInterface;
use Location\Bounds;
use Location\Coordinate;

/**
 * Bounds Factory
 */
class BoundsFactory
{
    /**
     *
     * @param Coordinate $center
     * @param float $distance in meter
     * @param BearingInterface $bearing
     * @return Bounds
     * @throws \InvalidArgumentException if bounds crosses the 180/-180 degrees meridian.
     */
    public static function expandFromCenterCoordinate(
        Coordinate $center,
        float $distance,
        BearingInterface $bearing
    ): Bounds {
        $NW = $bearing->calculateDestination($center, 315, $distance);
        $SE = $bearing->calculateDestination($center, 135, $distance);
        return new Bounds($NW, $SE);
    }
}
