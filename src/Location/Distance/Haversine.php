<?php
/**
 * Implementation of distance calculation with http://en.wikipedia.org/wiki/Law_of_haversines
 *
 * PHP version 5.3
 *
 * @category  Location
 * @package   Distance
 * @author    Marcus T. Jaschen <mjaschen@gmail.com>
 * @copyright 2013 r03.org
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      http://r03.org/
 */

namespace Location\Distance;

use Location\Coordinate;
use Location\Exception\NotConvergingException;
use Location\Exception\NotMatchingEllipsoidException;

/**
 * Implementation of distance calculation with http://en.wikipedia.org/wiki/Law_of_haversines
 *
 * @see http://en.wikipedia.org/wiki/Law_of_haversines
 *
 * @category Location
 * @package  Distance
 * @author   Marcus T. Jaschen <mjaschen@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://r03.org/
 */
class Haversine implements DistanceInterface
{
    /**
     * @param Coordinate $point1
     * @param Coordinate $point2
     *
     * @throws NotMatchingEllipsoidException
     *
     * @return float
     */
    public function getDistance(Coordinate $point1, Coordinate $point2)
    {
        if ($point1->getEllipsoid() != $point2->getEllipsoid()) {
            throw new NotMatchingEllipsoidException("The ellipsoids for both coordinates must match");
        }

        $lat1 = deg2rad($point1->getLat());
        $lat2 = deg2rad($point2->getLat());
        $lng1 = deg2rad($point1->getLng());
        $lng2 = deg2rad($point2->getLng());

        $dLat = $lat2 - $lat1;
        $dLng = $lng2 - $lng1;

        $radius = $point1->getEllipsoid()->getArithmeticMeanRadius();

        $s = 2 * $radius * asin(
            sqrt(
                pow(sin($dLat / 2), 2)
                + cos($lat1) * cos($lat2) * pow(sin($dLng / 2), 2)
            )
        );

        return round($s, 3);
    }
}