<?php
/**
 * Polygon Implementation
 *
 * PHP version 5
 *
 * @category  Location
 * @author    Paul Vidal <paul.vidal.lujan@gmail.com>
 * @copyright 1999-2013 MTB-News.de
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      http://www.mtb-news.de/
 */

namespace Location;

use Location\Distance\DistanceInterface,
    Location\Formatter\Polygon\FormatterInterface;

/**
 * Polygon Implementation
 *
 * @category Location
 * @author   Paul Vidal <paul.vidal.lujan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://www.mtb-news.de/
 */
class Polygon
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
     * Return all polygon point's latitudes.
     *
     * @return float
     */
    public function getLats()
    {
        $lats = array();

        foreach ($this->points as $point) {
            $lats[] = $point->getLat();
        }

        return $lats;
    }

    /**
     * Return all polygon point's longitudes.
     *
     * @return float
     */
    public function getLngs()
    {
        $lngs = array();

        foreach ($this->points as $point) {
            $lngs[] = $point->getLng();
        }

        return $lngs;
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
     * Determine if given point is contained inside the polygon.
     *
     * @param Coordinate $point
     *
     * @return boolean
     */
    public function contains(Coordinate $point)
    {
        $numberOfPoints = $this->getNumberOfPoints();
        $polygonLats = $this->getLats();
        $polygonLngs = $this->getLngs();

        $i = $j = $c = 0;

        for ($i = 0, $j = $numberOfPoints-1 ; $i < $numberOfPoints; $j = $i++) {
            if ( (($polygonLngs[$i]  >  $point->getLng() != ($polygonLngs[$j] > $point->getLng())) && ($point->getLat() < ($polygonLats[$j] - $polygonLats[$i]) * ($point->getLng() - $polygonLngs[$i]) / ($polygonLngs[$j] - $polygonLngs[$i]) + $polygonLats[$i]) ) ){
                $c = !$c;
            }
        }

        return $c == 0 ? false : $c;
    }

    /**
     * Calculates the polygon perimeter.
     *
     * @param DistanceInterface $calculator instance of distance calculation class
     *
     * @return float
     */
    public function getPerimeter(DistanceInterface $calculator)
    {
        $perimeter = 0.0;

        if (count($this->points) < 2) {
            return $perimeter;
        }

        foreach ($this->getSegments() as $segment) {
            $perimeter += $segment->getLength($calculator);
        }

        return $perimeter;
    }

    /**
     * Calculates the polygon area.
     *
     * @return float
     */
    public function getArea()
    {
        $area = 0.0;

        $numberOfPoints = $this->getNumberOfPoints();
        if ($numberOfPoints < 2) {
            return $area;
        }

        foreach ($this->points as $key => $point) {
            $j = ($key + 1) % $numberOfPoints;
            $area += ($this->points[$j]->getLng() * $point->getLat()) - ($point->getLng() * $this->points[$j]->getLat());
        }

        return abs( $area / 2 ) * $this->points[0]->getEllipsoid()->getA();
    }
}
