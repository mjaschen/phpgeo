<?php

declare(strict_types=1);

namespace Location\CardinalDirection;

use Location\Coordinate;

/** @psalm-immutable */
class CardinalDirection
{
    public const CARDINAL_DIRECTION_NONE = 'none';
    public const CARDINAL_DIRECTION_NORTH = 'north';
    public const CARDINAL_DIRECTION_EAST = 'east';
    public const CARDINAL_DIRECTION_SOUTH = 'south';
    public const CARDINAL_DIRECTION_WEST = 'west';
    public const CARDINAL_DIRECTION_NORTHEAST = 'north-east';
    public const CARDINAL_DIRECTION_NORTHWEST = 'north-west';
    public const CARDINAL_DIRECTION_SOUTHEAST = 'south-east';
    public const CARDINAL_DIRECTION_SOUTHWEST = 'south-west';

    public function getCardinalDirection(Coordinate $point1, Coordinate $point2): string
    {
        $directionFunctionMapping = [
            self::CARDINAL_DIRECTION_NORTH => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isOnlyNorth($point1, $point2);
            },
            self::CARDINAL_DIRECTION_EAST => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isOnlyEast($point1, $point2);
            },
            self::CARDINAL_DIRECTION_SOUTH => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isOnlySouth($point1, $point2);
            },
            self::CARDINAL_DIRECTION_WEST => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isOnlyWest($point1, $point2);
            },
            self::CARDINAL_DIRECTION_NORTHEAST => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isNorthEast($point1, $point2);
            },
            self::CARDINAL_DIRECTION_SOUTHEAST => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isSouthEast($point1, $point2);
            },
            self::CARDINAL_DIRECTION_SOUTHWEST => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isSouthWest($point1, $point2);
            },
            self::CARDINAL_DIRECTION_NORTHWEST => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isNorthWest($point1, $point2);
            },
        ];

        foreach ($directionFunctionMapping as $direction => $checkFunction) {
            if ($checkFunction($point1, $point2)) {
                return $direction;
            }
        }

        return self::CARDINAL_DIRECTION_NONE;
    }

    private function isOnlyNorth(Coordinate $point1, Coordinate $point2): bool
    {
        return !$this->isEastFrom($point1, $point2)
            && !$this->isSouthFrom($point1, $point2)
            && !$this->isWestFrom($point1, $point2)
            && $this->isNorthFrom($point1, $point2);
    }

    private function isOnlyEast(Coordinate $point1, Coordinate $point2): bool
    {
        return $this->isEastFrom($point1, $point2)
            && !$this->isSouthFrom($point1, $point2)
            && !$this->isWestFrom($point1, $point2)
            && !$this->isNorthFrom($point1, $point2);
    }

    private function isOnlySouth(Coordinate $point1, Coordinate $point2): bool
    {
        return !$this->isEastFrom($point1, $point2)
            && $this->isSouthFrom($point1, $point2)
            && !$this->isWestFrom($point1, $point2)
            && !$this->isNorthFrom($point1, $point2);
    }

    private function isOnlyWest(Coordinate $point1, Coordinate $point2): bool
    {
        return !$this->isEastFrom($point1, $point2)
            && !$this->isSouthFrom($point1, $point2)
            && $this->isWestFrom($point1, $point2)
            && !$this->isNorthFrom($point1, $point2);
    }

    private function isNorthEast(Coordinate $point1, Coordinate $point2): bool
    {
        return $this->isEastFrom($point1, $point2)
            && !$this->isSouthFrom($point1, $point2)
            && !$this->isWestFrom($point1, $point2)
            && $this->isNorthFrom($point1, $point2);
    }

    private function isSouthEast(Coordinate $point1, Coordinate $point2): bool
    {
        return $this->isEastFrom($point1, $point2)
            && $this->isSouthFrom($point1, $point2)
            && !$this->isWestFrom($point1, $point2)
            && !$this->isNorthFrom($point1, $point2);
    }

    private function isSouthWest(Coordinate $point1, Coordinate $point2): bool
    {
        return !$this->isEastFrom($point1, $point2)
            && $this->isSouthFrom($point1, $point2)
            && $this->isWestFrom($point1, $point2)
            && !$this->isNorthFrom($point1, $point2);
    }

    private function isNorthWest(Coordinate $point1, Coordinate $point2): bool
    {
        return !$this->isEastFrom($point1, $point2)
            && !$this->isSouthFrom($point1, $point2)
            && $this->isWestFrom($point1, $point2)
            && $this->isNorthFrom($point1, $point2);
    }

    private function isNorthFrom(Coordinate $point1, Coordinate $point2): bool
    {
        return $point1->getLat() > $point2->getLat();
    }

    private function isSouthFrom(Coordinate $point1, Coordinate $point2): bool
    {
        return $point1->getLat() < $point2->getLat();
    }

    private function isEastFrom(Coordinate $point1, Coordinate $point2): bool
    {
        return $point1->getLng() > $point2->getLng();
    }

    private function isWestFrom(Coordinate $point1, Coordinate $point2): bool
    {
        return $point1->getLng() < $point2->getLng();
    }
}
