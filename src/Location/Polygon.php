<?php
/**
 * Polygon Implementation
 *
 * PHP version 5
 *
 * @author    Paul Vidal <paul.vidal.lujan@gmail.com>
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @license   https://opensource.org/licenses/GPL-3.0 GPL
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location;

use Location\Distance\DistanceInterface;
use Location\Formatter\Polygon\FormatterInterface;

/**
 * Polygon Implementation
 *
 * @author   Paul Vidal <paul.vidal.lujan@gmail.com>
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
class Polygon implements GeometryInterface
{
    /**
     * @var array
     */
    protected $points = [];

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
     * @return float[]
     */
    public function getLats()
    {
        $lats = [];

        foreach ($this->points as $point) {
            $lats[] = $point->getLat();
        }

        return $lats;
    }

    /**
     * Return all polygon point's longitudes.
     *
     * @return float[]
     */
    public function getLngs()
    {
        $lngs = [];

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
        $segments = [];

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
     * Determine if given geometry is contained inside the polygon. This is
     * assumed to be true, if each point of the geometry is inside the polygon.
     *
     * Edge cases:
     *
     * - it's not detected when a line between two points is outside the polygon
     * - @see contains() for more restrictions
     *
     * @param GeometryInterface $geometry
     *
     * @return boolean
     */
    public function containsGeometry(GeometryInterface $geometry)
    {
        $geometryInPolygon = true;

        /** @var Coordinate $point */
        foreach ($geometry->getPoints() as $point) {
            $geometryInPolygon = $geometryInPolygon && $this->contains($point);
        }

        return $geometryInPolygon;
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
     * This algorithm gives inaccurate results as it ignores
     * ellipsoid parameters other than to arithmetic mean radius.
     * The error should be < 1 % for small areas.
     *
     * @return float
     */
    public function getArea()
    {
        $area = 0;

        if ($this->getNumberOfPoints() <= 2) {
            return $area;
        }

        $referencePoint = $this->points[0];
        $radius = $referencePoint->getEllipsoid()->getArithmeticMeanRadius();
        $segments = $this->getSegments();

        foreach ($segments as $segment) {
            /** @var Coordinate $point1 */
            $point1 = $segment->getPoint1();
            /** @var Coordinate $point2 */
            $point2 = $segment->getPoint2();

            $x1 = deg2rad($point1->getLng() - $referencePoint->getLng()) * cos(deg2rad($point1->getLat()));
            $y1 = deg2rad($point1->getLat() - $referencePoint->getLat());

            $x2 = deg2rad($point2->getLng() - $referencePoint->getLng()) * cos(deg2rad($point2->getLat()));
            $y2 = deg2rad($point2->getLat() - $referencePoint->getLat());

            $area += ($x2 * $y1 - $x1 * $y2);
        }

        $area *= 0.5 * pow($radius, 2);
        $area = abs($area);

        return $area;
    }

    /**
     * Create a new polygon with reversed order of points, i. e. reversed
     * polygon direction.
     *
     * @return Polygon
     */
    public function getReverse()
    {
        $reversed = new static();

        foreach (array_reverse($this->points) as $point) {
            $reversed->addPoint($point);
        }

        return $reversed;
    }
}
