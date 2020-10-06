<?php

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
        $north = $this->isNorthFrom($point1, $point2);
        $south = $this->isSouthFrom($point1, $point2);
        $west = $this->isWestFrom($point1, $point2);
        $east = $this->isEastFrom($point1, $point2);

        if (!$north && !$south) {
            if ($west) {
                return self::CARDINAL_DIRECTION_WEST;
            } elseif ($east) {
                return self::CARDINAL_DIRECTION_EAST;
            }
        }

        if (!$west && !$east) {
            if ($south) {
                return self::CARDINAL_DIRECTION_SOUTH;
            } elseif ($north) {
                return self::CARDINAL_DIRECTION_NORTH;
            }
        }

        if ($south) {
            if ($west) {
                return self::CARDINAL_DIRECTION_SOUTHWEST;
            } elseif ($east) {
                return self::CARDINAL_DIRECTION_SOUTHEAST;
            }
        }

        if ($north) {
            if ($west) {
                return self::CARDINAL_DIRECTION_NORTHWEST;
            } elseif ($east) {
                return self::CARDINAL_DIRECTION_NORTHEAST;
            }
        }

        return self::CARDINAL_DIRECTION_NONE;
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
