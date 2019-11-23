<?php

declare(strict_types=1);

namespace Location;

interface GeometryInterface
{
    /**
     * Returns an array containing all assigned points.
     *
     * @return Coordinate[]
     */
    public function getPoints(): array;
}
