<?php

declare(strict_types=1);

namespace Location;

/**
 * Coordinate Bounds Class
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class Bounds
{
    /**
     * @var Coordinate
     */
    protected $northWest;

    /**
     * @var Coordinate
     */
    protected $southEast;

    /**
     * @param Coordinate $northWest
     * @param Coordinate $southEast
     */
    public function __construct(Coordinate $northWest, Coordinate $southEast)
    {
        $this->northWest = $northWest;
        $this->southEast = $southEast;
    }

    /**
     * Getter
     *
     * @return Coordinate
     */
    public function getNorthWest(): Coordinate
    {
        return $this->northWest;
    }

    /**
     * Getter
     *
     * @return Coordinate
     */
    public function getSouthEast(): Coordinate
    {
        return $this->southEast;
    }

    /**
     * @return float
     */
    public function getNorth(): float
    {
        return $this->northWest->getLat();
    }

    /**
     * @return float
     */
    public function getSouth(): float
    {
        return $this->southEast->getLat();
    }

    /**
     * @return float
     */
    public function getWest(): float
    {
        return $this->northWest->getLng();
    }

    /**
     * @return float
     */
    public function getEast(): float
    {
        return $this->southEast->getLng();
    }

    /**
     * Calculates the center of this bounds object and returns it as a
     * Coordinate instance.
     *
     * @return Coordinate
     * @throws \InvalidArgumentException
     */
    public function getCenter(): Coordinate
    {
        $centerLat = ($this->getNorth() + $this->getSouth()) / 2;

        return new Coordinate($centerLat, $this->getCenterLng());
    }

    /**
     * @return float
     */
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
}
