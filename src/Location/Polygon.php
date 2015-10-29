<?php
/**
 * Polygon Implementation
 *
 * PHP version 5
 *
 * @category  Location
 * @author    Paul Vidal <paul.vidal.lujan@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      http://www.mtb-news.de/
 */

namespace Location;

use Location\Distance\DistanceInterface;
use Location\Formatter\Polygon\FormatterInterface;

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
    public function addPoint(Coordinate $point)
    {
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
            $segments[]    = new Line($previousPoint, $point);
            $previousPoint = $point;
        }

        // to close the polygon we have to add the final segment between
        // the last point and the first point
        $segments[] = new Line(end($this->points), reset($this->points));

        return $segments;
    }

    /**
     * Determine if given point is contained inside the polygon. Uses the PNPOLY
     * algorithm by W. Randolph Franklin. Therfore some edge cases may not give the
     * expected results, e. g. if the point resides on the polygon boundary.
     *
     * @see http://www.ecse.rpi.edu/Homepages/wrf/Research/Short_Notes/pnpoly.html
     *
     * For special cases this calculation leads to wrong results:
     *
     * - if the polygons spans over the longitude boundaries at 180/-180 degrees
     *
     * @param Coordinate $point
     *
     * @return boolean
     */
    public function contains(Coordinate $point)
    {
        $numberOfPoints = $this->getNumberOfPoints();
        $polygonLats    = $this->getLats();
        $polygonLngs    = $this->getLngs();

        $polygonContainsPoint = false;

        for ($node = 0, $altNode = ($numberOfPoints - 1); $node < $numberOfPoints; $altNode = $node ++) {
            if (($polygonLngs[$node] > $point->getLng() != ($polygonLngs[$altNode] > $point->getLng()))
                && ($point->getLat() < ($polygonLats[$altNode] - $polygonLats[$node])
                                       * ($point->getLng() - $polygonLngs[$node])
                                       / ($polygonLngs[$altNode] - $polygonLngs[$node])
                                       + $polygonLats[$node]
                )
            ) {
                $polygonContainsPoint = ! $polygonContainsPoint;
            }
        }

        return $polygonContainsPoint;
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
     *
     * @fixme This calculation gives wrong results, please don't use it!
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
            $area += ($this->points[$j]->getLng() * $point->getLat())
                     - ($point->getLng() * $this->points[$j]->getLat());
        }

        return abs($area / 2) * $this->points[0]->getEllipsoid()->getA();
    }
}
