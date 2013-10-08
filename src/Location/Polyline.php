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

use Location\Distance\DistanceInterface,
    Location\Formatter\Polyline\FormatterInterface;

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
    protected $points = array();

    /**
     * @param Coordinate $point
     */
    public function addPoint(Coordinate $point) {
        $this->points[] = $point;
    }

    /**
     * @return array
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return int
     */
    public function getNumberOfPoints()
    {
        return count($this->points);
    }

    /**
     * @param FormatterInterface $formatter
     *
     * @return mixed
     */
    public function format(FormatterInterface $formatter)
    {
        return $formatter->format($this);
    }

    /**
     * @return array
     */
    public function getSegments()
    {
        $segments = array();

        if (count($this->points) <= 1) {
            return $segments;
        }

        $previousPoint = reset($this->points);

        while ($point = next($this->points)) {
            $segments[] = new Line($previousPoint, $point);
            $previousPoint = $point;
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

        if (count($this->points) <= 1) {
            return $distance;
        }

        $previousPoint = reset($this->points);

        while ($point = next($this->points)) {
            $distance += $calculator->getDistance($previousPoint, $point);
            $previousPoint = $point;
        }

        return $distance;
    }
}
