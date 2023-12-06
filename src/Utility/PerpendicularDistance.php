<?php

declare(strict_types=1);

namespace Location\Utility;

use Location\Coordinate;
use Location\Line;

/**
 * Calculate the perpendicular distance between a Line and a Point with a simple spherical model.
 */
class PerpendicularDistance
{
    public function getPerpendicularDistance(Coordinate $point, Line $line): float
    {
        $ellipsoid = $point->getEllipsoid();

        $ellipsoidRadius = $ellipsoid->getArithmeticMeanRadius();

        $firstLinePointLat = $this->deg2radLatitude($line->point1->getLat());
        $firstLinePointLng = $this->deg2radLongitude($line->point1->getLng());

        $firstLinePointX = $ellipsoidRadius * cos($firstLinePointLng) * sin($firstLinePointLat);
        $firstLinePointY = $ellipsoidRadius * sin($firstLinePointLng) * sin($firstLinePointLat);
        $firstLinePointZ = $ellipsoidRadius * cos($firstLinePointLat);

        $secondLinePointLat = $this->deg2radLatitude($line->point2->getLat());
        $secondLinePointLng = $this->deg2radLongitude($line->point2->getLng());

        $secondLinePointX = $ellipsoidRadius * cos($secondLinePointLng) * sin($secondLinePointLat);
        $secondLinePointY = $ellipsoidRadius * sin($secondLinePointLng) * sin($secondLinePointLat);
        $secondLinePointZ = $ellipsoidRadius * cos($secondLinePointLat);

        $pointLat = $this->deg2radLatitude($point->getLat());
        $pointLng = $this->deg2radLongitude($point->getLng());

        $pointX = $ellipsoidRadius * cos($pointLng) * sin($pointLat);
        $pointY = $ellipsoidRadius * sin($pointLng) * sin($pointLat);
        $pointZ = $ellipsoidRadius * cos($pointLat);

        $normalizedX = $firstLinePointY * $secondLinePointZ - $firstLinePointZ * $secondLinePointY;
        $normalizedY = $firstLinePointZ * $secondLinePointX - $firstLinePointX * $secondLinePointZ;
        $normalizedZ = $firstLinePointX * $secondLinePointY - $firstLinePointY * $secondLinePointX;

        $length = sqrt($normalizedX * $normalizedX + $normalizedY * $normalizedY + $normalizedZ * $normalizedZ);

        if ($length == 0.0) {
            return 0;
        }

        $normalizedX /= $length;
        $normalizedY /= $length;
        $normalizedZ /= $length;

        $thetaPoint = $normalizedX * $pointX + $normalizedY * $pointY + $normalizedZ * $pointZ;

        $length = sqrt($pointX * $pointX + $pointY * $pointY + $pointZ * $pointZ);

        $thetaPoint /= $length;

        $distance = abs((M_PI / 2) - acos($thetaPoint));

        return $distance * $ellipsoidRadius;
    }

    protected function deg2radLatitude(float $latitude): float
    {
        return deg2rad(90 - $latitude);
    }

    protected function deg2radLongitude(float $longitude): float
    {
        if ($longitude > 0) {
            return deg2rad($longitude);
        }

        return deg2rad($longitude + 360);
    }
}
