<?php
/**
 * Calculate the perpendicular distance between a Line and a Point
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */

namespace Location\Utility;

use Location\Coordinate;
use Location\Line;

/**
 * Calculate the perpendicular distance between a Line and a Point
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
class PerpendicularDistance
{
    /**
     * @param Coordinate $point
     * @param Line $line
     *
     * @return float
     */
    public function getPerpendicularDistance(Coordinate $point, Line $line)
    {
        $ellipsoid = $point->getEllipsoid();

        $ellipsoidRadius = $ellipsoid->getArithmeticMeanRadius();

        $firstLinePointLat = $this->deg2radLatitude($line->getPoint1()->getLat());
        $firstLinePointLng = $this->deg2radLongitude($line->getPoint1()->getLng());

        $firstLinePointX = $ellipsoidRadius * cos($firstLinePointLng) * sin($firstLinePointLat);
        $firstLinePointY = $ellipsoidRadius * sin($firstLinePointLng) * sin($firstLinePointLat);
        $firstLinePointZ = $ellipsoidRadius * cos($firstLinePointLat);

        $secondLinePointLat = $this->deg2radLatitude($line->getPoint2()->getLat());
        $secondLinePointLng = $this->deg2radLongitude($line->getPoint2()->getLng());

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

        $normalizedX /= $length;
        $normalizedY /= $length;
        $normalizedZ /= $length;

        $thetaPoint = $normalizedX * $pointX + $normalizedY * $pointY + $normalizedZ * $pointZ;

        $length = sqrt($pointX * $pointX + $pointY * $pointY + $pointZ * $pointZ);

        $thetaPoint /= $length;

        $distance = abs((M_PI / 2) - acos($thetaPoint));

        return $distance * $ellipsoidRadius;
    }

    /**
     * @param float $latitude
     *
     * @return float
     */
    protected function deg2radLatitude($latitude)
    {
        return deg2rad(90 - $latitude);
    }

    /**
     * @param float $longitude
     *
     * @return float
     */
    protected function deg2radLongitude($longitude)
    {
        if ($longitude > 0) {
            return deg2rad($longitude);
        }

        return deg2rad($longitude + 360);
    }
}
