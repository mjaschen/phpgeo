<?php
/**
 * Implementation of distance calculation with Vincenty Method
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @license   https://opensource.org/licenses/GPL-3.0 GPL
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Distance;

use Location\Coordinate;
use Location\Exception\NotConvergingException;
use Location\Exception\NotMatchingEllipsoidException;

/**
 * Implementation of distance calculation with Vincenty Method
 *
 * @see      http://www.movable-type.co.uk/scripts/latlong-vincenty.html
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
class Vincenty implements DistanceInterface
{
    /**
     * @param Coordinate $point1
     * @param Coordinate $point2
     *
     * @throws NotMatchingEllipsoidException
     * @throws NotConvergingException
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

        $a = $point1->getEllipsoid()->getA();
        $b = $point1->getEllipsoid()->getB();
        $f = 1 / $point1->getEllipsoid()->getF();

        $L  = $lng2 - $lng1;
        $U1 = atan((1 - $f) * tan($lat1));
        $U2 = atan((1 - $f) * tan($lat2));

        $iterationLimit = 100;
        $lambda         = $L;

        $sinU1 = sin($U1);
        $sinU2 = sin($U2);
        $cosU1 = cos($U1);
        $cosU2 = cos($U2);

        do {
            $sinLambda = sin($lambda);
            $cosLambda = cos($lambda);

            $sinSigma = sqrt(
                ($cosU2 * $sinLambda) * ($cosU2 * $sinLambda) +
                ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda) * ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda)
            );

            if ($sinSigma == 0) {
                return 0.0;
            }

            $cosSigma = $sinU1 * $sinU2 + $cosU1 * $cosU2 * $cosLambda;

            $sigma = atan2($sinSigma, $cosSigma);

            $sinAlpha = $cosU1 * $cosU2 * $sinLambda / $sinSigma;

            $cosSqAlpha = 1 - $sinAlpha * $sinAlpha;

            $cos2SigmaM = 0;
            if ($cosSqAlpha <> 0) {
                $cos2SigmaM = $cosSigma - 2 * $sinU1 * $sinU2 / $cosSqAlpha;
            }

            $C = $f / 16 * $cosSqAlpha * (4 + $f * (4 - 3 * $cosSqAlpha));

            $lambdaP = $lambda;

            $lambda = $L + (1 - $C) * $f * $sinAlpha * ($sigma + $C * $sinSigma * ($cos2SigmaM + $C * $cosSigma * (- 1 + 2 * $cos2SigmaM * $cos2SigmaM)));
        } while (abs($lambda - $lambdaP) > 1e-12 && -- $iterationLimit > 0);

        if ($iterationLimit == 0) {
            throw new NotConvergingException();
        }

        $uSq        = $cosSqAlpha * ($a * $a - $b * $b) / ($b * $b);
        $A          = 1 + $uSq / 16384 * (4096 + $uSq * (- 768 + $uSq * (320 - 175 * $uSq)));
        $B          = $uSq / 1024 * (256 + $uSq * (- 128 + $uSq * (74 - 47 * $uSq)));
        $deltaSigma = $B * $sinSigma * ($cos2SigmaM + $B / 4 * ($cosSigma * (- 1 + 2 * $cos2SigmaM * $cos2SigmaM) - $B / 6 * $cos2SigmaM * (- 3 + 4 * $sinSigma * $sinSigma) * (- 3 + 4 * $cos2SigmaM * $cos2SigmaM)));
        $s          = $b * $A * ($sigma - $deltaSigma);

        return (round($s, 3));
    }
}
