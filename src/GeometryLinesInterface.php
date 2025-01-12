<?php

declare(strict_types=1);

namespace Location;

interface GeometryLinesInterface extends GeometryInterface
{
    /**
     * Returns an array containing all assigned line segments.
     *
     * @return array<Line>
     */
    public function getSegments(): array;
}
