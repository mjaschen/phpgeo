<?php

declare(strict_types=1);

namespace Location\Distance;

use Location\Coordinate;
use Location\Exception\NotConvergingException;
use Location\Exception\NotMatchingEllipsoidException;

/**
 * Implementation of distance calculation with http://en.wikipedia.org/wiki/Law_of_haversines
 *
 * @see http://en.wikipedia.org/wiki/Law_of_haversines
 */
class Haversine implements DistanceInterface
{
    /**
     * @throws NotMatchingEllipsoidException
     *
     * @return float Distance in meters
     */
    public function getDistance(Coordinate $point1, Coordinate $point2): float
    {
        if ($point1->getEllipsoid()->getName() !== $point2->getEllipsoid()->getName()) {
            throw new NotMatchingEllipsoidException('The ellipsoids for both coordinates must match');
        }

        $lat1 = deg2rad($point1->getLat());
        $lat2 = deg2rad($point2->getLat());
        $lng1 = deg2rad($point1->getLng());
        $lng2 = deg2rad($point2->getLng());

        $dLat = $lat2 - $lat1;
        $dLng = $lng2 - $lng1;

        $radius = $point1->getEllipsoid()->getArithmeticMeanRadius();

        $distance = 2 * $radius * asin(
            sqrt(
                (sin($dLat / 2) ** 2)
                + cos($lat1) * cos($lat2) * (sin($dLng / 2) ** 2)
            )
        );

        return round($distance, 3);
    }
}
