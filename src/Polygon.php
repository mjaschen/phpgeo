<?php

declare(strict_types=1);

namespace Location;

use Location\Distance\DistanceInterface;
use Location\Formatter\Polygon\FormatterInterface;

/**
 * Polygon Implementation
 *
 * @author Paul Vidal <paul.vidal.lujan@gmail.com>
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class Polygon implements GeometryInterface
{
    use GetBoundsTrait;

    /**
     * @var array<Coordinate>
     */
    protected $points = [];

    /**
     * @param Coordinate $point
     *
     * @return void
     */
    public function addPoint(Coordinate $point): void
    {
        $this->points[] = $point;
    }

    /**
     * @param array<Coordinate> $points
     */
    public function addPoints(array $points): void
    {
        foreach ($points as $point) {
            $this->addPoint($point);
        }
    }

    /**
     * @return array<Coordinate>
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * Return all polygon point's latitudes.
     *
     * @return array<float>
     */
    public function getLats(): array
    {
        $lats = [];

        foreach ($this->points as $point) {
            /** @var Coordinate $point */
            $lats[] = $point->getLat();
        }

        return $lats;
    }

    /**
     * Return all polygon point's longitudes.
     *
     * @return array<float>
     */
    public function getLngs(): array
    {
        $lngs = [];

        foreach ($this->points as $point) {
            /** @var Coordinate $point */
            $lngs[] = $point->getLng();
        }

        return $lngs;
    }

    /**
     * @return int
     */
    public function getNumberOfPoints(): int
    {
        return count($this->points);
    }

    /**
     * @param FormatterInterface $formatter
     *
     * @return string
     */
    public function format(FormatterInterface $formatter): string
    {
        return $formatter->format($this);
    }

    /**
     * @return array<Line>
     */
    public function getSegments(): array
    {
        $length = count($this->points);
        $segments = [];

        if ($length <= 1) {
            return $segments;
        }

        for ($i = 1; $i < $length; $i++) {
            $segments[] = new Line($this->points[$i - 1], $this->points[$i]);
        }

        // to close the polygon we have to add the final segment between
        // the last point and the first point
        $segments[] = new Line($this->points[$i - 1], $this->points[0]);

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
     * @return bool
     */
    public function containsGeometry(GeometryInterface $geometry): bool
    {
        $geometryInPolygon = true;

        foreach ($geometry->getPoints() as $point) {
            $geometryInPolygon = $geometryInPolygon && $this->contains($point);
        }

        return $geometryInPolygon;
    }

    /**
     * Determine if given point is contained inside the polygon. Uses the PNPOLY
     * algorithm by W. Randolph Franklin. Therfore some edge cases may not give the
     * expected results, e.g. if the point resides on the polygon boundary.
     *
     * @see https://wrf.ecse.rpi.edu/Research/Short_Notes/pnpoly.html
     *
     * For special cases this calculation leads to wrong results:
     *
     * - if the polygons spans over the longitude boundaries at 180/-180 degrees
     *
     * @param Coordinate $point
     *
     * @return bool
     */
    public function contains(Coordinate $point): bool
    {
        $numberOfPoints = $this->getNumberOfPoints();
        $polygonLats    = $this->getLats();
        $polygonLngs    = $this->getLngs();

        $polygonContainsPoint = false;

        for ($node = 0, $altNode = $numberOfPoints - 1; $node < $numberOfPoints; $altNode = $node++) {
            $condition = ($polygonLngs[$node] > $point->getLng()) !== ($polygonLngs[$altNode] > $point->getLng())
                && ($point->getLat() < ($polygonLats[$altNode] - $polygonLats[$node])
                    * ($point->getLng() - $polygonLngs[$node])
                    / ($polygonLngs[$altNode] - $polygonLngs[$node]) + $polygonLats[$node]);

            if ($condition) {
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
    public function getPerimeter(DistanceInterface $calculator): float
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
    public function getArea(): float
    {
        $area = 0;

        if ($this->getNumberOfPoints() <= 2) {
            return $area;
        }

        $referencePoint = $this->points[0];
        $radius         = $referencePoint->getEllipsoid()->getArithmeticMeanRadius();
        $segments       = $this->getSegments();

        foreach ($segments as $segment) {
            $point1 = $segment->getPoint1();
            $point2 = $segment->getPoint2();

            $x1 = deg2rad($point1->getLng() - $referencePoint->getLng()) * cos(deg2rad($point1->getLat()));
            $y1 = deg2rad($point1->getLat() - $referencePoint->getLat());

            $x2 = deg2rad($point2->getLng() - $referencePoint->getLng()) * cos(deg2rad($point2->getLat()));
            $y2 = deg2rad($point2->getLat() - $referencePoint->getLat());

            $area += ($x2 * $y1 - $x1 * $y2);
        }

        $area *= 0.5 * $radius ** 2;

        return abs($area);
    }

    /**
     * Create a new polygon with reversed order of points, i. e. reversed
     * polygon direction.
     *
     * @return Polygon
     */
    public function getReverse(): Polygon
    {
        $reversed = new self();

        foreach (array_reverse($this->points) as $point) {
            $reversed->addPoint($point);
        }

        return $reversed;
    }
}
