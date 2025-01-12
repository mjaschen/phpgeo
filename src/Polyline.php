<?php

declare(strict_types=1);

namespace Location;

use Location\Distance\DistanceInterface;
use Location\Exception\InvalidGeometryException;
use Location\Formatter\Polyline\FormatterInterface;

class Polyline implements GeometryLinesInterface
{
    use GetBoundsTrait;

    /**
     * @var array<Coordinate>
     */
    protected array $points = [];

    /**
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
        $this->points = [...$this->points, ...$points];
    }

    /**
     * Adds an unique point to the polyline. A maximum allowed distance for
     * same point comparison can be provided. Default allowed distance
     * deviation is 0.001 meters (1 millimeter).
     */
    public function addUniquePoint(Coordinate $point, float $allowedDistance = .001): void
    {
        if ($this->containsPoint($point, $allowedDistance)) {
            return;
        }

        $this->addPoint($point);
    }

    /**
     * @return array<Coordinate>
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    public function getNumberOfPoints(): int
    {
        return count($this->points);
    }

    public function containsPoint(Coordinate $point, float $allowedDistance = .001): bool
    {
        foreach ($this->points as $existingPoint) {
            if ($existingPoint->hasSameLocation($point, $allowedDistance)) {
                return true;
            }
        }

        return false;
    }

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

        return $segments;
    }

    /**
     * Calculates the length of the polyline.
     *
     * @param DistanceInterface $calculator instance of distance calculation class
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
     */
    public function getReverse(): Polyline
    {
        $reversed = new self();

        foreach (array_reverse($this->points) as $point) {
            $reversed->addPoint($point);
        }

        return $reversed;
    }

    /**
     * Returns the point which is defined by the avarages of all
     * latitude/longitude values.
     *
     * This currently only works for polylines which don't cross the dateline at
     * 180/-180 degrees longitude.
     *
     * @throws InvalidGeometryException when the polyline doesn't contain any points.
     */
    public function getAveragePoint(): Coordinate
    {
        $latitude = 0.0;
        $longitude = 0.0;
        $numberOfPoints = count($this->points);

        if ($this->getNumberOfPoints() === 0) {
            throw new InvalidGeometryException('Polyline doesn\'t contain points', 9464188927);
        }

        foreach ($this->points as $point) {
            $latitude += $point->getLat();
            $longitude += $point->getLng();
        }

        $latitude /= $numberOfPoints;
        $longitude /= $numberOfPoints;

        return new Coordinate($latitude, $longitude);
    }
}
