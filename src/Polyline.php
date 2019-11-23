<?php

declare(strict_types=1);

namespace Location;

use Location\Distance\DistanceInterface;
use Location\Formatter\Polyline\FormatterInterface;

/**
 * Polyline Implementation
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class Polyline implements GeometryInterface
{
    use GetBoundsTrait;

    /**
     * @var Coordinate[]
     */
    protected $points = [];

    /**
     * @param Coordinate $point
     *
     * @return void
     */
    public function addPoint(Coordinate $point)
    {
        $this->points[] = $point;
    }

    /**
     * Adds an unique point to the polyline. A maximum allowed distance for
     * same point comparison can be provided. Default allowed distance
     * deviation is 0.001 meters (1 millimeter).
     *
     * @param Coordinate $point
     * @param float $allowedDistance
     *
     * @return void
     */
    public function addUniquePoint(Coordinate $point, float $allowedDistance = .001)
    {
        if ($this->containsPoint($point, $allowedDistance)) {
            return;
        }

        $this->addPoint($point);
    }

    /**
     * @return Coordinate[]
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * @return int
     */
    public function getNumberOfPoints(): int
    {
        return count($this->points);
    }

    /**
     * @param Coordinate $point
     * @param float $allowedDistance
     *
     * @return bool
     */
    public function containsPoint(Coordinate $point, float $allowedDistance = .001): bool
    {
        foreach ($this->points as $existingPoint) {
            if ($existingPoint->isSame($point, $allowedDistance)) {
                return true;
            }
        }

        return false;
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
     * @return Line[]
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

        return $segments;
    }

    /**
     * Calculates the length of the polyline.
     *
     * @param DistanceInterface $calculator instance of distance calculation class
     *
     * @return float
     */
    public function getLength(DistanceInterface $calculator): float
    {
        $distance = 0.0;

        if (count($this->points) <= 1) {
            return $distance;
        }

        foreach ($this->getSegments() as $segment) {
            $distance += $segment->getLength($calculator);
        }

        return $distance;
    }

    /**
     * Create a new polyline with reversed order of points, i. e. reversed
     * polyline direction.
     *
     * @return Polyline
     */
    public function getReverse(): Polyline
    {
        $reversed = new static();

        foreach (array_reverse($this->points) as $point) {
            $reversed->addPoint($point);
        }

        return $reversed;
    }

    /**
     * @return Coordinate|null
     */
    public function getMiddlePoint(): ?Coordinate
    {
        $lat = 0.0;
        $lng = 0.0;
        $numberOfPoints = count($this->points);

        if($numberOfPoints < 1) {
            return null;
        }

        foreach($this->points as $point) {
            /* @var $point Coordinate */
            $lat += $point->getLat();
            $lng += $point->getLng();
        }

        $lat /= $numberOfPoints;
        $lng /= $numberOfPoints;

        return new Coordinate($lat, $lng);
    }
}
