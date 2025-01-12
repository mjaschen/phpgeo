<?php

declare(strict_types=1);

namespace Location;

interface GeometryInterface
{
    /**
     * Returns an array containing all assigned points.
     *
     * @return array<Coordinate>
     */
    public function getPoints(): array;

    public function getBounds(): Bounds;
}
