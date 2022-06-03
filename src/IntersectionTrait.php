<?php

declare(strict_types=1);

namespace Location;

use Location\Direction\Direction;

trait IntersectionTrait
{
    public function intersects(GeometryInterface $geometry, bool $precise = false): bool
    {
        if ($this instanceof Polygon && $geometry instanceof Coordinate) {
            return $this->contains($geometry);
        }

        if ($precise === true) {
            return $this->intersectsGeometry($geometry);
        }

        return $this->intersectsBounds($geometry->getBounds());
    }

    /**
     * Checks if this geometry's bounds and the given bounds intersect.
     */
    public function intersectsBounds(Bounds $otherBounds): bool
    {
        $direction = new Direction();
        $bounds = $this->getBounds();

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
    public function intersectsGeometry(GeometryInterface $geometry): bool
    {
        foreach ($this->getSegments() as $segment) {
            foreach ($geometry->getSegments() as $otherSegment) {
                if ($segment->intersectsLine($otherSegment)) {
                    return true;
                }
            }
        }

        return false;
    }
}
