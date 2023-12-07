<?php

declare(strict_types=1);

namespace Location\Bearing;

use InvalidArgumentException;
use Location\Coordinate;

/**
 * Calculation of bearing between two points using a
 * simple spherical model of the earth.
 */
class BearingSpherical implements BearingInterface
{
    /**
     * Earth radius in meters.
     */
    private const EARTH_RADIUS = 6371009.0;

    /**
     * This method calculates the initial bearing (forward azimut) between
     * the two given points.
     *
     * @return float Bearing Angle in degrees
     */
    public function calculateBearing(Coordinate $point1, Coordinate $point2): float
    {
        $lat1 = deg2rad($point1->getLat());
        $lat2 = deg2rad($point2->getLat());
        $lng1 = deg2rad($point1->getLng());
        $lng2 = deg2rad($point2->getLng());

        $y = sin($lng2 - $lng1) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($lng2 - $lng1);

        $bearing = rad2deg(atan2($y, $x));

        if ($bearing < 0) {
            $bearing = fmod($bearing + 360, 360);
        }

        return $bearing;
    }

    /**
     * Calculates the final bearing between the two points.
     *
     * @return float Bearing Angle in degrees
     */
    public function calculateFinalBearing(Coordinate $point1, Coordinate $point2): float
    {
        $initialBearing = $this->calculateBearing($point2, $point1);

        return fmod($initialBearing + 180, 360);
    }

    /**
     * Calculates a destination point for the given point, bearing angle,
     * and distance.
     *
     * @param float $bearing the bearing angle between 0 and 360 degrees
     * @param float $distance the distance to the destination point in meters
     *
     * @throws InvalidArgumentException
     */
    public function calculateDestination(Coordinate $point, float $bearing, float $distance): Coordinate
    {
        $D = $distance / self::EARTH_RADIUS;
        $B = deg2rad($bearing);
        $φ = deg2rad($point->getLat());
        $λ = deg2rad($point->getLng());

        $Φ = asin(sin($φ) * cos($D) + cos($φ) * sin($D) * cos($B));
        $Λ = $λ + atan2(sin($B) * sin($D) * cos($φ), cos($D) - sin($φ) * sin($φ));

        return new Coordinate(rad2deg($Φ), rad2deg($Λ));
    }
}
