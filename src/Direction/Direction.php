<?php

declare(strict_types=1);

namespace Location\Direction;

use Location\Coordinate;

class Direction
{
    public function isNorthOf(Coordinate $point1, Coordinate $point2): bool
    {
        return $point1->getLat() > $point2->getLat();
    }

    public function isSouthOf(Coordinate $point1, Coordinate $point2): bool
    {
        return $point1->getLat() < $point2->getLat();
    }

    public function isEastOf(Coordinate $point1, Coordinate $point2): bool
    {
        return $point1->getLng() > $point2->getLng();
    }

    public function isWestOf(Coordinate $point1, Coordinate $point2): bool
    {
        return $point1->getLng() < $point2->getLng();
    }
}
