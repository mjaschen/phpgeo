<?php

declare(strict_types=1);

namespace Location\Bearing;

use InvalidArgumentException;
use Location\Coordinate;
use Location\Exception\NotConvergingException;

/**
 * Calculation of bearing between two points using a
 * ellipsoidal model of the earth.
 *
 * This class is based on the awesome work Chris Veness
 * has done. For more information visit the following URL.
 *
 * @see http://www.movable-type.co.uk/scripts/latlong-vincenty.html
 */
class BearingEllipsoidal implements BearingInterface
{
    /**
     * This method calculates the initial bearing between the
     * two points.
     *
     * If the two points share the same location, the bearing
     * value will be 0.0.
     *
     * @return float Bearing Angle
     */
    public function calculateBearing(Coordinate $point1, Coordinate $point2): float
    {
        if ($point1->hasSameLocation($point2)) {
            return 0.0;
        }

        return $this->inverseVincenty($point1, $point2)->bearingInitial;
    }

    /**
     * Calculates the final bearing between the two points.
     *
     * @return float Bearing Angle
     */
    public function calculateFinalBearing(Coordinate $point1, Coordinate $point2): float
    {
        return $this->inverseVincenty($point1, $point2)->bearingFinal;
    }

    /**
     * Calculates a destination point for the given point, bearing angle,
     * and distance.
     *
     * @param float $bearing the bearing angle between 0 and 360 degrees
     * @param float $distance the distance to the destination point in meters
     */
    public function calculateDestination(Coordinate $point, float $bearing, float $distance): Coordinate
    {
        return $this->directVincenty($point, $bearing, $distance)->destination;
    }

    /**
     * Calculates the final bearing angle for a destination point.
     * The method expects a starting point point, the bearing angle,
     * and the distance to destination.
     *
     * @return float Bearing Angle
     *
     * @throws NotConvergingException
     */
    public function calculateDestinationFinalBearing(Coordinate $point, float $bearing, float $distance): float
    {
        return $this->directVincenty($point, $bearing, $distance)->bearingFinal;
    }

    /**
     * @throws NotConvergingException
     */
    private function directVincenty(Coordinate $point, float $bearing, float $distance): DirectVincentyBearing
    {
        $phi1 = deg2rad($point->getLat());
        $lambda1 = deg2rad($point->getLng());
        $alpha1 = deg2rad($bearing);

        $a = $point->getEllipsoid()->getA();
        $b = $point->getEllipsoid()->getB();
        $f = 1 / $point->getEllipsoid()->getF();

        $sinAlpha1 = sin($alpha1);
        $cosAlpha1 = cos($alpha1);

        $tanU1 = (1 - $f) * tan($phi1);
        $cosU1 = 1 / sqrt(1 + $tanU1 * $tanU1);
        $sinU1 = $tanU1 * $cosU1;
        $sigma1 = atan2($tanU1, $cosAlpha1);
        $sinAlpha = $cosU1 * $sinAlpha1;
        $cosSquAlpha = 1 - $sinAlpha * $sinAlpha;
        $uSq = $cosSquAlpha * ($a * $a - $b * $b) / ($b * $b);
        $A = 1 + $uSq / 16384 * (4096 + $uSq * (-768 + $uSq * (320 - 175 * $uSq)));
        $B = $uSq / 1024 * (256 + $uSq * (-128 + $uSq * (74 - 47 * $uSq)));

        $sigmaS = $distance / ($b * $A);
        $sigma = $sigmaS;
        $iterations = 0;

        do {
            $cos2SigmaM = cos(2 * $sigma1 + $sigma);
            $sinSigma = sin($sigma);
            $cosSigma = cos($sigma);
            $deltaSigma = $B * $sinSigma
                * ($cos2SigmaM + $B / 4
                    * ($cosSigma
                        * (-1 + 2 * $cos2SigmaM * $cos2SigmaM) - $B / 6
                        * $cos2SigmaM * (-3 + 4 * $sinSigma * $sinSigma)
                        * (-3 + 4 * $cos2SigmaM * $cos2SigmaM)
                    )
                );
            $sigmaS = $sigma;
            $sigma = $distance / ($b * $A) + $deltaSigma;
            $iterations++;
        } while (abs($sigma - $sigmaS) > 1e-12 && $iterations < 200);

        if ($iterations >= 200) {
            throw new NotConvergingException('Inverse Vincenty Formula did not converge');
        }

        $tmp = $sinU1 * $sinSigma - $cosU1 * $cosSigma * $cosAlpha1;
        $phi2 = atan2(
            $sinU1 * $cosSigma + $cosU1 * $sinSigma * $cosAlpha1,
            (1 - $f) * sqrt($sinAlpha * $sinAlpha + $tmp * $tmp)
        );
        $lambda = atan2($sinSigma * $sinAlpha1, $cosU1 * $cosSigma - $sinU1 * $sinSigma * $cosAlpha1);
        $C = $f / 16 * $cosSquAlpha * (4 + $f * (4 - 3 * $cosSquAlpha));
        $L = $lambda
            - (1 - $C) * $f * $sinAlpha
            * ($sigma + $C * $sinSigma * ($cos2SigmaM + $C * $cosSigma * (-1 + 2 * $cos2SigmaM ** 2)));
        $lambda2 = fmod($lambda1 + $L + 3 * M_PI, 2 * M_PI) - M_PI;

        $alpha2 = atan2($sinAlpha, -$tmp);
        $alpha2 = fmod($alpha2 + 2 * M_PI, 2 * M_PI);

        return new DirectVincentyBearing(
            new Coordinate(rad2deg($phi2), rad2deg($lambda2), $point->getEllipsoid()),
            rad2deg($alpha2)
        );
    }

    /**
     * @throws NotConvergingException
     */
    private function inverseVincenty(Coordinate $point1, Coordinate $point2): InverseVincentyBearing
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
            $sinλ = sin($λ);
            $cosλ = cos($λ);
            $sinSqσ = ($cosU2 * $sinλ) * ($cosU2 * $sinλ)
                + ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosλ) * ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosλ);
            $sinσ = sqrt($sinSqσ);

            if ($sinσ == 0) {
                return new InverseVincentyBearing(0, 0, 0);
            }

            $cosσ = $sinU1 * $sinU2 + $cosU1 * $cosU2 * $cosλ;
            $σ = atan2($sinσ, $cosσ);
            $sinα = $cosU1 * $cosU2 * $sinλ / $sinσ;
            $cosSqα = 1 - $sinα * $sinα;

            $cos2σM = 0;
            if ($cosSqα !== 0.0) {
                $cos2σM = $cosσ - 2 * $sinU1 * $sinU2 / $cosSqα;
            }

            $C = $f / 16 * $cosSqα * (4 + $f * (4 - 3 * $cosSqα));
            $λp = $λ;
            $λ = $L + (1 - $C) * $f * $sinα
                * ($σ + $C * $sinσ * ($cos2σM + $C * $cosσ * (-1 + 2 * $cos2σM * $cos2σM)));
            $iterations++;
        } while (abs($λ - $λp) > 1e-12 && $iterations < 200);

        if ($iterations >= 200) {
            throw new NotConvergingException('Inverse Vincenty Formula did not converge');
        }

        $uSq = $cosSqα * ($a * $a - $b * $b) / ($b * $b);
        $A = 1 + $uSq / 16384 * (4096 + $uSq * (-768 + $uSq * (320 - 175 * $uSq)));
        $B = $uSq / 1024 * (256 + $uSq * (-128 + $uSq * (74 - 47 * $uSq)));
        $Δσ = $B * $sinσ
            * ($cos2σM + $B / 4
                * ($cosσ * (-1 + 2 * $cos2σM * $cos2σM) - $B / 6
                    * $cos2σM * (-3 + 4 * $sinσ * $sinσ)
                    * (-3 + 4 * $cos2σM * $cos2σM)
                )
            );

        $s = $b * $A * ($σ - $Δσ);

        $α1 = atan2($cosU2 * $sinλ, $cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosλ);
        $α2 = atan2($cosU1 * $sinλ, -$sinU1 * $cosU2 + $cosU1 * $sinU2 * $cosλ);

        $α1 = fmod($α1 + 2 * M_PI, 2 * M_PI);
        $α2 = fmod($α2 + 2 * M_PI, 2 * M_PI);

        $s = round($s, 3);

        return new InverseVincentyBearing($s, rad2deg($α1), rad2deg($α2));
    }
}
