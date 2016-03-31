<?php
/**
 * Calculation of bearing between two points using a
 * ellipsoidal model of the earth
 *
 * This class is based on the awesome work Chris Veness
 * has done. For more information visit the following URL.
 *
 * @see http://www.movable-type.co.uk/scripts/latlong-vincenty.html
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */

namespace Location\Bearing;

use Location\Coordinate;
use Location\Exception\NotConvergingException;

/**
 * Calculation of bearing between two points using a
 * ellipsoidal model of the earth
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
class BearingEllipsoidal implements BearingInterface
{
    /**
     * This method calculates the initial bearing between the
     * two points.
     *
     * @param \Location\Coordinate $point1
     * @param \Location\Coordinate $point2
     *
     * @return float Bearing Angle
     */
    public function calculateBearing(Coordinate $point1, Coordinate $point2)
    {
        return $this->inverseVincenty($point1, $point2)['bearing_initial'];
    }

    /**
     * Calculates the final bearing between the two points.
     *
     * @param \Location\Coordinate $point1
     * @param \Location\Coordinate $point2
     *
     * @return float
     */
    public function calculateFinalBearing(Coordinate $point1, Coordinate $point2)
    {
        return $this->inverseVincenty($point1, $point2)['bearing_final'];
    }

    /**
     * Calculates a destination point for the given point, bearing angle,
     * and distance.
     *
     * @param \Location\Coordinate $point
     * @param float $bearing the bearing angle between 0 and 360 degrees
     * @param float $distance the distance to the destination point in meters
     *
     * @return Coordinate
     */
    public function calculateDestination(Coordinate $point, $bearing, $distance)
    {
        return $this->directVincenty($point, $bearing, $distance)['destination'];
    }

    /**
     * Calculates the final bearing angle for a destination point.
     * The method expects a starting point point, the bearing angle,
     * and the distance to destination.
     *
     * @param \Location\Coordinate $point
     * @param float $bearing
     * @param float $distance
     *
     * @return float
     */
    public function calculateDestinationFinalBearing(Coordinate $point, $bearing, $distance)
    {
        return $this->directVincenty($point, $bearing, $distance)['bearing_final'];
    }

    private function directVincenty(Coordinate $point, $bearing, $distance)
    {
        $φ1 = deg2rad($point->getLat());
        $λ1 = deg2rad($point->getLng());
        $α1 = deg2rad($bearing);

        $a = $point->getEllipsoid()->getA();
        $b = $point->getEllipsoid()->getB();
        $f = 1 / $point->getEllipsoid()->getF();

        $sinα1 = sin($α1);
        $cosα1 = cos($α1);

        $tanU1  = (1 - $f) * tan($φ1);
        $cosU1  = 1 / sqrt(1 + $tanU1 * $tanU1);
        $sinU1  = $tanU1 * $cosU1;
        $σ1     = atan2($tanU1, $cosα1);
        $sinα   = $cosU1 * $sinα1;
        $cosSqα = 1 - $sinα * $sinα;
        $uSq    = $cosSqα * ($a * $a - $b * $b) / ($b * $b);
        $A      = 1 + $uSq / 16384 * (4096 + $uSq * (- 768 + $uSq * (320 - 175 * $uSq)));
        $B      = $uSq / 1024 * (256 + $uSq * (- 128 + $uSq * (74 - 47 * $uSq)));

        $σ          = $distance / ($b * $A);
        $iterations = 0;

        do {
            $cos2σm = cos(2 * $σ1 + $σ);
            $sinσ   = sin($σ);
            $cosσ   = cos($σ);
            $Δσ     = $B * $sinσ * ($cos2σm + $B / 4 * ($cosσ * (- 1 + 2 * $cos2σm * $cos2σm) - $B / 6 * $cos2σm * (- 3 + 4 * $sinσ * $sinσ) * (- 3 + 4 * $cos2σm * $cos2σm)));
            $σs     = $σ;
            $σ      = $distance / ($b * $A) + $Δσ;
        } while (abs($σ - $σs) > 1e-12 && ++ $iterations < 200);

        if ($iterations >= 200) {
            throw new NotConvergingException('Inverse Vincenty Formula did not converge');
        }

        $tmp = $sinU1 * $sinσ - $cosU1 * $cosσ * $cosα1;
        $φ2  = atan2($sinU1 * $cosσ + $cosU1 * $sinσ * $cosα1, (1 - $f) * sqrt($sinα * $sinα + $tmp * $tmp));
        $λ   = atan2($sinσ * $sinα1, $cosU1 * $cosσ - $sinU1 * $sinσ * $cosα1);
        $C   = $f / 16 * $cosSqα * (4 + $f * (4 - 3 * $cosSqα));
        $L   = $λ - (1 - $C) * $f * $sinα * ($σ + $C * $sinσ * ($cos2σm + $C * $cosσ * (- 1 + 2 * $cos2σm * $cos2σm)));
        $λ2  = fmod($λ1 + $L + 3 * M_PI, 2 * M_PI) - M_PI;

        $α2 = atan2($sinα, - $tmp);
        $α2 = fmod($α2 + 2 * M_PI, 2 * M_PI);

        return [
            'destination'   => new Coordinate(rad2deg($φ2), rad2deg($λ2), $point->getEllipsoid()),
            'bearing_final' => rad2deg($α2),
        ];
    }

    private function inverseVincenty(Coordinate $point1, Coordinate $point2)
    {
        $φ1 = deg2rad($point1->getLat());
        $φ2 = deg2rad($point2->getLat());
        $λ1 = deg2rad($point1->getLng());
        $λ2 = deg2rad($point2->getLng());

        $a = $point1->getEllipsoid()->getA();
        $b = $point1->getEllipsoid()->getB();
        $f = 1 / $point1->getEllipsoid()->getF();

        $L = $λ2 - $λ1;

        $tanU1 = (1 - $f) * tan($φ1);
        $cosU1 = 1 / sqrt(1 + $tanU1 * $tanU1);
        $sinU1 = $tanU1 * $cosU1;
        $tanU2 = (1 - $f) * tan($φ2);
        $cosU2 = 1 / sqrt(1 + $tanU2 * $tanU2);
        $sinU2 = $tanU2 * $cosU2;

        $λ = $L;

        $iterations = 0;

        do {
            $sinλ   = sin($λ);
            $cosλ   = cos($λ);
            $sinSqσ = ($cosU2 * $sinλ) * ($cosU2 * $sinλ)
                      + ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosλ) * ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosλ);
            $sinσ   = sqrt($sinSqσ);

            if ($sinσ == 0) {
                return 0;
            }

            $cosσ   = $sinU1 * $sinU2 + $cosU1 * $cosU2 * $cosλ;
            $σ      = atan2($sinσ, $cosσ);
            $sinα   = $cosU1 * $cosU2 * $sinλ / $sinσ;
            $cosSqα = 1 - $sinα * $sinα;

            $cos2σM = 0;
            if ($cosSqα !== 0.0) {
                $cos2σM = $cosσ - 2 * $sinU1 * $sinU2 / $cosSqα;
            }

            $C  = $f / 16 * $cosSqα * (4 + $f * (4 - 3 * $cosSqα));
            $λp = $λ;
            $λ  = $L + (1 - $C) * $f * $sinα * ($σ + $C * $sinσ * ($cos2σM + $C * $cosσ * (- 1 + 2 * $cos2σM * $cos2σM)));
        } while (abs($λ - $λp) > 1e-12 && ++ $iterations < 200);

        if ($iterations >= 200) {
            throw new NotConvergingException('Inverse Vincenty Formula did not converge');
        }

        $uSq = $cosSqα * ($a * $a - $b * $b) / ($b * $b);
        $A   = 1 + $uSq / 16384 * (4096 + $uSq * (- 768 + $uSq * (320 - 175 * $uSq)));
        $B   = $uSq / 1024 * (256 + $uSq * (- 128 + $uSq * (74 - 47 * $uSq)));
        $Δσ  = $B * $sinσ * ($cos2σM + $B / 4 * ($cosσ * (- 1 + 2 * $cos2σM * $cos2σM) - $B / 6 * $cos2σM * (- 3 + 4 * $sinσ * $sinσ) * (- 3 + 4 * $cos2σM * $cos2σM)));

        $s = $b * $A * ($σ - $Δσ);

        $α1 = atan2($cosU2 * $sinλ, $cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosλ);
        $α2 = atan2($cosU1 * $sinλ, - $sinU1 * $cosU2 + $cosU1 * $sinU2 * $cosλ);

        $α1 = fmod($α1 + 2 * M_PI, 2 * M_PI);
        $α2 = fmod($α2 + 2 * M_PI, 2 * M_PI);

        $s = round($s, 3);

        return [
            'distance'        => $s,
            'bearing_initial' => rad2deg($α1),
            'bearing_final'   => rad2deg($α2),
        ];
    }
}
