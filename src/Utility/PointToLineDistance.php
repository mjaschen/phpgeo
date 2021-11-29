<?php

declare(strict_types=1);

namespace Location\Utility;

use Location\Coordinate;
use Location\Distance\DistanceInterface;
use Location\Line;

/**
 * Calculate the distance between a Line and a Point.
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class PointToLineDistance
{
    /**
     * @var DistanceInterface
     */
    private $distanceCalculator;

    public function __construct(DistanceInterface $distanceCalculator)
    {
        $this->distanceCalculator = $distanceCalculator;
    }

    public function getDistance(Coordinate $point, Line $line): float
    {
        if ($line->getPoint1()->hasSameLocation($line->getPoint2())) {
            return $this->distanceCalculator->getDistance($point, $line->getPoint1());
        }

        $pLat = deg2rad($point->getLat());
        $pLng = deg2rad($point->getLng());

        $l1Lat = deg2rad($line->getPoint1()->getLat());
        $l1Lng = deg2rad($line->getPoint1()->getLng());
        $l2Lat = deg2rad($line->getPoint2()->getLat());
        $l2Lng = deg2rad($line->getPoint2()->getLng());

        $deltal2l1Lat = $l2Lat - $l1Lat;
        $deltal2l1Lng = $l2Lng - $l1Lng;

        $u = (($pLat - $l1Lat) * $deltal2l1Lat + ($pLng - $l1Lng) * $deltal2l1Lng) /
            ($deltal2l1Lat ** 2 + $deltal2l1Lng ** 2);

        if ($u <= 0) {
            return $this->distanceCalculator->getDistance($point, $line->getPoint1());
        }

        if ($u >= 1) {
            return $this->distanceCalculator->getDistance($point, $line->getPoint2());
        }

        return (new PerpendicularDistance())->getPerpendicularDistance($point, $line);
    }
}
