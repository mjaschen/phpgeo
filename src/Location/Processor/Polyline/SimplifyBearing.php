<?php
/**
 * Simplify Polyline
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */

namespace Location\Processor\Polyline;

use Location\Bearing\BearingEllipsoidal;
use Location\Polyline;

/**
 * Simplify Polyline
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
class SimplifyBearing implements SimplifyInterface
{
    /**
     * @var float
     */
    private $bearingAngle;

    /**
     * SimplifyBearing constructor.
     *
     * @param float $bearingAngle
     */
    public function __construct($bearingAngle)
    {
        $this->bearingAngle = $bearingAngle;
    }

    /**
     * Simplifies the given polyline
     *
     * 1. calculate the bearing angle between the first two points p1 and p2: b1
     * 2. calculate the bearing angle between the next two points p2 and p3: b2
     * 3. calculate the difference between b1 and b2: deltaB; if deltaB is
     *    smaller than the threshold angle, remove the middle point p2
     * 4. start again at (1.) as long as the polyline contains more points
     *
     * @param Polyline $polyline
     *
     * @return Polyline
     */
    public function simplify(Polyline $polyline)
    {
        $counterPoints = $polyline->getNumberOfPoints();

        if ($counterPoints < 3) {
            return clone $polyline;
        }

        $result      = new Polyline();
        $bearingCalc = new BearingEllipsoidal();

        $points = $polyline->getPoints();

        $index = 0;

        // add the first point to the resulting polyline
        $result->addPoint($points[$index]);

        do {
            $index++;

            // preserve the last point of the original polyline
            if ($index === ($counterPoints - 1)) {
                $result->addPoint($points[$index]);
                break;
            }

            $bearing1 = $bearingCalc->calculateBearing($points[$index - 1], $points[$index]);
            $bearing2 = $bearingCalc->calculateBearing($points[$index], $points[$index + 1]);

            $bearingDifference = min(
                fmod($bearing1 - $bearing2 + 360, 360),
                fmod($bearing2 - $bearing1 + 360, 360)
            );

            if ($bearingDifference > $this->bearingAngle) {
                $result->addPoint($points[$index]);
            }
        } while ($index < $counterPoints);

        return $result;
    }
}
