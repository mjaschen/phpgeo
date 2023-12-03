<?php

declare(strict_types=1);

namespace Location\CardinalDirection;

use Location\Coordinate;
use Location\Direction\Direction;

class CardinalDirection
{
    final public const CARDINAL_DIRECTION_NONE = 'none';
    final public const CARDINAL_DIRECTION_NORTH = 'north';
    final public const CARDINAL_DIRECTION_EAST = 'east';
    final public const CARDINAL_DIRECTION_SOUTH = 'south';
    final public const CARDINAL_DIRECTION_WEST = 'west';
    final public const CARDINAL_DIRECTION_NORTHEAST = 'north-east';
    final public const CARDINAL_DIRECTION_NORTHWEST = 'north-west';
    final public const CARDINAL_DIRECTION_SOUTHEAST = 'south-east';
    final public const CARDINAL_DIRECTION_SOUTHWEST = 'south-west';

    private readonly \Location\Direction\Direction $direction;

    public function __construct()
    {
        $this->direction = new Direction();
    }

    public function getCardinalDirection(Coordinate $point1, Coordinate $point2): string
    {
        $directionFunctionMapping = [
            self::CARDINAL_DIRECTION_NORTH => fn(
                Coordinate $point1,
                Coordinate $point2
            ): bool => $this->isStrictlyNorth($point1, $point2),
            self::CARDINAL_DIRECTION_EAST => fn(
                Coordinate $point1,
                Coordinate $point2
            ): bool => $this->isStrictlyEast($point1, $point2),
            self::CARDINAL_DIRECTION_SOUTH => fn(
                Coordinate $point1,
                Coordinate $point2
            ): bool => $this->isStrictlySouth($point1, $point2),
            self::CARDINAL_DIRECTION_WEST => fn(
                Coordinate $point1,
                Coordinate $point2
            ): bool => $this->isStrictlyWest($point1, $point2),
            self::CARDINAL_DIRECTION_NORTHEAST => fn(
                Coordinate $point1,
                Coordinate $point2
            ): bool => $this->isNorthEast($point1, $point2),
            self::CARDINAL_DIRECTION_SOUTHEAST => fn(
                Coordinate $point1,
                Coordinate $point2
            ): bool => $this->isSouthEast($point1, $point2),
            self::CARDINAL_DIRECTION_SOUTHWEST => fn(
                Coordinate $point1,
                Coordinate $point2
            ): bool => $this->isSouthWest($point1, $point2),
            self::CARDINAL_DIRECTION_NORTHWEST => fn(
                Coordinate $point1,
                Coordinate $point2
            ): bool => $this->isNorthWest($point1, $point2),
        ];

        foreach ($directionFunctionMapping as $direction => $checkFunction) {
            if ($checkFunction($point1, $point2)) {
                return $direction;
            }
        }

        return self::CARDINAL_DIRECTION_NONE;
    }

    private function isStrictlyNorth(Coordinate $point1, Coordinate $point2): bool
    {
        return !$this->direction->pointIsEastOf($point1, $point2)
            && !$this->direction->pointIsSouthOf($point1, $point2)
            && !$this->direction->pointIsWestOf($point1, $point2)
            && $this->direction->pointIsNorthOf($point1, $point2);
    }

    private function isStrictlyEast(Coordinate $point1, Coordinate $point2): bool
    {
        return $this->direction->pointIsEastOf($point1, $point2)
            && !$this->direction->pointIsSouthOf($point1, $point2)
            && !$this->direction->pointIsWestOf($point1, $point2)
            && !$this->direction->pointIsNorthOf($point1, $point2);
    }

    private function isStrictlySouth(Coordinate $point1, Coordinate $point2): bool
    {
        return !$this->direction->pointIsEastOf($point1, $point2)
            && $this->direction->pointIsSouthOf($point1, $point2)
            && !$this->direction->pointIsWestOf($point1, $point2)
            && !$this->direction->pointIsNorthOf($point1, $point2);
    }

    private function isStrictlyWest(Coordinate $point1, Coordinate $point2): bool
    {
        return !$this->direction->pointIsEastOf($point1, $point2)
            && !$this->direction->pointIsSouthOf($point1, $point2)
            && $this->direction->pointIsWestOf($point1, $point2)
            && !$this->direction->pointIsNorthOf($point1, $point2);
    }

    private function isNorthEast(Coordinate $point1, Coordinate $point2): bool
    {
        return $this->direction->pointIsEastOf($point1, $point2)
            && !$this->direction->pointIsSouthOf($point1, $point2)
            && !$this->direction->pointIsWestOf($point1, $point2)
            && $this->direction->pointIsNorthOf($point1, $point2);
    }

    private function isSouthEast(Coordinate $point1, Coordinate $point2): bool
    {
        return $this->direction->pointIsEastOf($point1, $point2)
            && $this->direction->pointIsSouthOf($point1, $point2)
            && !$this->direction->pointIsWestOf($point1, $point2)
            && !$this->direction->pointIsNorthOf($point1, $point2);
    }

    private function isSouthWest(Coordinate $point1, Coordinate $point2): bool
    {
        return !$this->direction->pointIsEastOf($point1, $point2)
            && $this->direction->pointIsSouthOf($point1, $point2)
            && $this->direction->pointIsWestOf($point1, $point2)
            && !$this->direction->pointIsNorthOf($point1, $point2);
    }

    private function isNorthWest(Coordinate $point1, Coordinate $point2): bool
    {
        return !$this->direction->pointIsEastOf($point1, $point2)
            && !$this->direction->pointIsSouthOf($point1, $point2)
            && $this->direction->pointIsWestOf($point1, $point2)
            && $this->direction->pointIsNorthOf($point1, $point2);
    }
}
