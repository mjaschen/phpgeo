<?php

declare(strict_types=1);

namespace Location\CardinalDirection;

use Location\Coordinate;
use Location\Direction\Direction;

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

    /**
     * @var Direction
     */
    private $direction;

    public function __construct()
    {
        $this->direction = new Direction();
    }

    public function getCardinalDirection(Coordinate $point1, Coordinate $point2): string
    {
        $directionFunctionMapping = [
            self::CARDINAL_DIRECTION_NORTH => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isStrictlyNorth($point1, $point2);
            },
            self::CARDINAL_DIRECTION_EAST => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isStrictlyEast($point1, $point2);
            },
            self::CARDINAL_DIRECTION_SOUTH => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isStrictlySouth($point1, $point2);
            },
            self::CARDINAL_DIRECTION_WEST => function (Coordinate $point1, Coordinate $point2): bool {
                return $this->isStrictlyWest($point1, $point2);
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
