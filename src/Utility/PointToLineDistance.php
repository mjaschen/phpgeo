<?php

declare(strict_types=1);

namespace Location\Utility;

use Location\Coordinate;
use Location\Distance\DistanceInterface;
use Location\Line;

class PointToLineDistance
{
    /**
     * @var DistanceInterface
     */
    private $distanceCalculator;

    /**
     * PointToLineDistance constructor.
     * @param DistanceInterface $distanceCalculator
     */
    public function __construct(DistanceInterface $distanceCalculator)
    {
        $this->distanceCalculator = $distanceCalculator;
    }

    /**
     * @param Coordinate $point
     * @param Line $line
     *
     * @return float
     */
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

        $u = (($pLat - $l1Lat) * $deltal2l1Lat + ($pLng - $l1Lng) * $deltal2l1Lng) / ($deltal2l1Lat ** 2 + $deltal2l1Lng ** 2);

        if ($u <= 0) {
            return $this->distanceCalculator->getDistance($point, $line->getPoint1());
        }

        if ($u >= 1) {
            return $this->distanceCalculator->getDistance($point, $line->getPoint2());
        }

        $tmpPoint1 = new Coordinate(
            $point->getLat() - $line->getPoint1()->getLat(),
            $point->getLng() - $line->getPoint1()->getLng()
        );
        $tmpPoint2 = new Coordinate(
            $u * ($line->getPoint2()->getLat() - $line->getPoint1()->getLat()),
            $u * ($line->getPoint2()->getLng() - $line->getPoint1()->getLng())
        );

        return $this->distanceCalculator->getDistance($tmpPoint1, $tmpPoint2);
    }
}
