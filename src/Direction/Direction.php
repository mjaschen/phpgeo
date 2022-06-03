<?php

declare(strict_types=1);

namespace Location\Direction;

use Location\Coordinate;

class Direction
{
    public function isNorthOf(Coordinate $point, Coordinate $compareAgainst): bool
    {
        return $point->getLat() > $compareAgainst->getLat();
    }

    public function isSouthOf(Coordinate $point, Coordinate $compareAgainst): bool
    {
        return $point->getLat() < $compareAgainst->getLat();
    }

    public function isEastOf(Coordinate $point, Coordinate $compareAgainst): bool
    {
        return $point->getLng() > $compareAgainst->getLng();
    }

    public function isWestOf(Coordinate $point, Coordinate $compareAgainst): bool
    {
        return $point->getLng() < $compareAgainst->getLng();
    }
}
