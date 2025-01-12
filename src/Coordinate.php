<?php

declare(strict_types=1);

namespace Location;

use InvalidArgumentException;
use Location\CardinalDirection\CardinalDirectionDistances;
use Location\CardinalDirection\CardinalDirectionDistancesCalculator;
use Location\Distance\DistanceInterface;
use Location\Distance\Haversine;
use Location\Exception\InvalidGeometryException;
use Location\Formatter\Coordinate\FormatterInterface;

class Coordinate implements GeometryInterface
{
    protected Ellipsoid $ellipsoid;

    /**
     * @param float $lat -90.0 .. +90.0
     * @param float $lng -180.0 .. +180.0
     * @param ?Ellipsoid $ellipsoid if omitted, WGS-84 is used
     *
     * @throws InvalidArgumentException
     */
    public function __construct(protected float $lat, protected float $lng, Ellipsoid|null $ellipsoid = null)
    {
        if (! $this->isValidLatitude($lat)) {
            throw new InvalidArgumentException('Latitude value must be numeric -90.0 .. +90.0 (given: ' . $lat . ')');
        }

        if (! $this->isValidLongitude($lng)) {
            throw new InvalidArgumentException(
                'Longitude value must be numeric -180.0 .. +180.0 (given: ' . $lng . ')'
            );
        }

        if ($ellipsoid instanceof Ellipsoid) {
            $this->ellipsoid = $ellipsoid;

            return;
        }

        $this->ellipsoid = Ellipsoid::createDefault();
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLng(): float
    {
        return $this->lng;
    }

    /**
     * @return array<Coordinate>
     */
    public function getPoints(): array
    {
        return [$this];
    }

    public function getEllipsoid(): Ellipsoid
    {
        return $this->ellipsoid;
    }

    /**
     * Calculates the distance between the given coordinate
     * and this coordinate.
     */
    public function getDistance(Coordinate $coordinate, DistanceInterface $calculator): float
    {
        return $calculator->getDistance($this, $coordinate);
    }

    /**
     * Calculates the cardinal direction distances from this coordinate
     * to given coordinate.
     */
    public function getCardinalDirectionDistances(
        Coordinate $coordinate,
        DistanceInterface $calculator
    ): CardinalDirectionDistances {
        return (new CardinalDirectionDistancesCalculator())
            ->getCardinalDirectionDistances($this, $coordinate, $calculator);
    }

    /**
     * Checks if two points describe the same location within an allowed distance.
     *
     * Uses the Haversine distance calculator for distance calculation as it's
     * precise enough for short-distance calculations.
     *
     * @see Haversine
     */
    public function hasSameLocation(Coordinate $coordinate, float $allowedDistance = .001): bool
    {
        return $this->getDistance($coordinate, new Haversine()) <= $allowedDistance;
    }

    /**
     * Checks if this point intersects a given geometry.
     *
     * @throws InvalidGeometryException
     */
    public function intersects(GeometryInterface $geometry): bool
    {
        if ($geometry instanceof self) {
            return $this->hasSameLocation($geometry);
        }

        if ($geometry instanceof Polygon) {
            return $geometry->contains($this);
        }

        throw new InvalidGeometryException('Only polygons can contain other geometries', 1655191821);
    }

    public function format(FormatterInterface $formatter): string
    {
        return $formatter->format($this);
    }

    protected function isValidLatitude(float $latitude): bool
    {
        return $this->isNumericInBounds($latitude, -90.0, 90.0);
    }

    protected function isValidLongitude(float $longitude): bool
    {
        return $this->isNumericInBounds($longitude, -180.0, 180.0);
    }

    /**
     * Checks if the given value is (1) numeric, and (2) between lower
     * and upper bounds (including the bounds values).
     */
    protected function isNumericInBounds(float $value, float $lower, float $upper): bool
    {
        return !($value < $lower || $value > $upper);
    }

    public function getBounds(): Bounds
    {
        return new Bounds($this, $this);
    }

    public function getSegments(): never
    {
        throw new \RuntimeException('A single point instance does not contain valid segments', 6029644914);
    }
}
