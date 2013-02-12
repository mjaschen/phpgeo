<?php
/**
 * Abstract Distance Class
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

/**
 * Abstract Distance Class
 *
 * @category Location
 * @package  Distance
 * @author   Marcus T. Jaschen <mjaschen@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://r03.org/
 */
abstract class AbstractDistance
{
    /**
     * @param Coordinate $point1
     * @param Coordinate $point2
     *
     * @return float distance between the two coordinates in meters
     */
    abstract public function getDistance(Coordinate $point1, Coordinate $point2);
}