<?php
declare(strict_types=1);

/**
 * Interface for Distance Calculator Classes
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Distance;

use Location\Coordinate;

/**
 * Interface for Distance Calculator Classes
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */
interface DistanceInterface
{
    /**
     * @param Coordinate $point1
     * @param Coordinate $point2
     *
     * @return float distance between the two coordinates in meters
     */
    public function getDistance(Coordinate $point1, Coordinate $point2): float;
}
