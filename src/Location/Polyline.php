<?php
/**
 * Polyline Implementation
 *
 * PHP version 5
 *
 * @category  Location
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @copyright 1999-2013 MTB-News.de
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      http://www.mtb-news.de/
 */

namespace Location;

use Location\Distance\DistanceInterface;

/**
 * Polyline Implementation
 *
 * @category Location
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://www.mtb-news.de/
 */
class Polyline
{
    /**
     * @var array
     */
    protected $coordinates = array();

    /**
     * @param Coordinate $coordinate
     */
    public function addCoordinate(Coordinate $coordinate) {
        $this->coordinates[] = $coordinate;
    }

    /**
     * @return array
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @return array
     */
    public function getSegments()
    {
        $segments = array();

        if (count($this->coordinates) <= 1) {
            return $segments;
        }

        $previousCoordinate = reset($this->coordinates);

        while ($coordinate = next($this->coordinates)) {
            $segments[] = new Line($previousCoordinate, $coordinate);
            $previousCoordinate = $coordinate;
        }

        return $segments;
    }

    /**
     * Calculates the length of the polyline.
     *
     * @param DistanceInterface $calculator instance of distance calculation class
     *
     * @return float
     */
    public function getLength(DistanceInterface $calculator)
    {
        $distance = 0.0;

        if (count($this->coordinates) <= 1) {
            return $distance;
        }

        $previousCoordinate = reset($this->coordinates);

        while ($coordinate = next($this->coordinates)) {
            $distance += $calculator->getDistance($previousCoordinate, $coordinate);
            $previousCoordinate = $coordinate;
        }

        return $distance;
    }
}