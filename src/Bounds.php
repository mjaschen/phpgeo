<?php

declare(strict_types=1);

namespace Location;

class Bounds
{
    public function __construct(private readonly Coordinate $northWest, private readonly Coordinate $southEast)
    {
    }

    public function getNorthWest(): Coordinate
    {
        return $this->northWest;
    }

    public function getSouthEast(): Coordinate
    {
        return $this->southEast;
    }

    public function getNorthEast(): Coordinate
    {
        return new Coordinate($this->getNorth(), $this->getEast());
    }

    public function getSouthWest(): Coordinate
    {
        return new Coordinate($this->getSouth(), $this->getWest());
    }

    public function getNorth(): float
    {
        return $this->northWest->getLat();
    }

    public function getSouth(): float
    {
        return $this->southEast->getLat();
    }

    public function getWest(): float
    {
        return $this->northWest->getLng();
    }

    public function getEast(): float
    {
        return $this->southEast->getLng();
    }

    /**
     * Calculates the center of this bounds object and returns it as a
     * Coordinate instance.
     *
     * @throws \InvalidArgumentException
     */
    public function getCenter(): Coordinate
    {
        $centerLat = ($this->getNorth() + $this->getSouth()) / 2;

        return new Coordinate($centerLat, $this->getCenterLng());
    }

    protected function getCenterLng(): float
    {
        $centerLng = ($this->getEast() + $this->getWest()) / 2;

        $overlap = $this->getWest() > 0 && $this->getEast() < 0;

        if ($overlap && $centerLng > 0) {
            return -180.0 + $centerLng;
        }

        if ($overlap && $centerLng < 0) {
            return 180.0 + $centerLng;
        }

        if ($overlap && $centerLng == 0) {
            return 180.0;
        }

        return $centerLng;
    }

    /**
     * Creates the polygon described by this bounds object and returns the
     * Polygon instance.
     */
    public function getAsPolygon(): Polygon
    {
        $polygon = new Polygon();

        $polygon->addPoint($this->getNorthWest());
        $polygon->addPoint($this->getNorthEast());
        $polygon->addPoint($this->getSouthEast());
        $polygon->addPoint($this->getSouthWest());

        return $polygon;
    }
}
