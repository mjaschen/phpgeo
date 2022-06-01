<?php

declare(strict_types=1);

namespace Location;

use Location\CardinalDirection\CardinalDirection;

trait IntersectionTrait
{
    public function intersects($geometry, bool $precise = false): bool
    {
        if (
            is_a($geometry, 'Location\Coordinate') ||
            is_a($geometry, 'Location\Point')
        ) {
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
    public function intersectsBounds(Bounds $bounds2): bool
    {
        $direction = new CardinalDirection();
        $bounds1 = $this->getBounds();

        if (
            $direction->isEastOf(
                $bounds1->getSouthWest(),
                $bounds2->getSouthEast()
            ) ||
            $direction->isSouthOf(
                $bounds1->getNorthWest(),
                $bounds2->getSouthWest()
            ) ||
            $direction->isWestOf(
                $bounds1->getSouthEast(),
                $bounds2->getSouthWest()
            ) ||
            $direction->isNorthOf(
                $bounds1->getSouthWest(),
                $bounds2->getNorthWest()
            )
        ) {
            return false;
        }

        return true;
    }

    /**
     * Checks if this geometry and the given geometry intersect by checking
     * their segments for intersections.
     */
    public function intersectsGeometry($geometry): bool
    {
        $segments1 = $this->getSegments();
        $segments2 = $geometry->getSegments();
        $intersects = false;

        foreach ($segments1 as $segment1) {
            foreach ($segments2 as $segment2) {
                $intersects = $segment1->intersectsLine($segment2);

                if ($intersects === true) {
                    break;
                }
            }

            if ($intersects === true) {
                break;
            }
        }

        return $intersects;
    }
}
