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

        return $this->intersectsBounds($geometry1, $geometry2->getBounds());
    }

    /**
     * Checks if this geometry's bounds and the given bounds intersect.
     */
    public function intersectsBounds(GeometryInterface $geometry, Bounds $otherBounds): bool
    {
        $direction = new Direction();
        $bounds = $geometry->getBounds();

        return !(
            $direction->isEastOf($bounds->getSouthWest(), $otherBounds->getSouthEast())
            || $direction->isSouthOf($bounds->getNorthWest(), $otherBounds->getSouthWest())
            || $direction->isWestOf($bounds->getSouthEast(), $otherBounds->getSouthWest())
            || $direction->isNorthOf($bounds->getSouthWest(), $otherBounds->getNorthWest())
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
