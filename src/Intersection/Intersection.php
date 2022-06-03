<?php

declare(strict_types=1);

namespace Location\Intersection;

use Location\Bounds;
use Location\Coordinate;
use Location\Direction\Direction;
use Location\GeometryInterface;
use Location\Polygon;

class Intersection
{
    public function intersects(GeometryInterface $geometry1, GeometryInterface $geometry2, bool $precise = false): bool
    {
        if ($geometry1 instanceof Polygon && $geometry2 instanceof Coordinate) {
            return $geometry1->contains($geometry2);
        }

        if ($geometry1 instanceof Coordinate && $geometry2 instanceof Polygon) {
            return $geometry2->contains($geometry1);
        }

        if ($precise === true) {
            return $this->intersectsGeometry($geometry1, $geometry2);
        }

        return $this->intersectsBounds($geometry1, $geometry2);
    }

    /**
     * Checks if this geometry's bounds and the given bounds intersect.
     */
    public function intersectsBounds(GeometryInterface $geometry1, GeometryInterface $geometry2): bool
    {
        $direction = new Direction();

        return !(
            $direction->pointIsEastOf($geometry1->getBounds()->getSouthWest(), $geometry2->getBounds()->getSouthEast())
            || $direction->pointIsSouthOf($geometry1->getBounds()->getNorthWest(), $geometry2->getBounds()->getSouthWest())
            || $direction->pointIsWestOf($geometry1->getBounds()->getSouthEast(), $geometry2->getBounds()->getSouthWest())
            || $direction->pointIsNorthOf($geometry1->getBounds()->getSouthWest(), $geometry2->getBounds()->getNorthWest())
        );
    }

    /**
     * Checks if this geometry and the given geometry intersect by checking
     * their segments for intersections.
     */
    public function intersectsGeometry(GeometryInterface $geometry1, GeometryInterface $geometry2): bool
    {
        foreach ($geometry1->getSegments() as $segment) {
            foreach ($geometry2->getSegments() as $otherSegment) {
                if ($segment->intersectsLine($otherSegment)) {
                    return true;
                }
            }
        }

        return false;
    }
}
