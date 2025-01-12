<?php

declare(strict_types=1);

namespace Location\Intersection;

use Location\Bounds;
use Location\Coordinate;
use Location\Direction\Direction;
use Location\Exception\InvalidGeometryException;
use Location\GeometryInterface;
use Location\GeometryLinesInterface;
use Location\Line;
use Location\Polygon;
use Location\Polyline;

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

        if (!($geometry1 instanceof GeometryLinesInterface && $geometry2 instanceof GeometryLinesInterface)) {
            throw new InvalidGeometryException('Only can check intersections for geometries with lines', 3285305710);
        }

        if ($precise === true) {
            return $this->intersectsGeometry($geometry1, $geometry2);
        }

        return $this->intersectsBounds($geometry1, $geometry2);
    }

    /**
     * Checks if this geometry's bounds and the given bounds intersect.
     */
    private function intersectsBounds(GeometryInterface $geometry1, GeometryInterface $geometry2): bool
    {
        $direction = new Direction();
        $bounds1 = $geometry1->getBounds();
        $bounds2 = $geometry2->getBounds();

        return !(
            $direction->pointIsEastOf($bounds1->getSouthWest(), $bounds2->getSouthEast())
            || $direction->pointIsSouthOf($bounds1->getNorthWest(), $bounds2->getSouthWest())
            || $direction->pointIsWestOf($bounds1->getSouthEast(), $bounds2->getSouthWest())
            || $direction->pointIsNorthOf($bounds1->getSouthWest(), $bounds2->getNorthWest())
        );
    }

    /**
     * Checks if this geometry and the given geometry intersect by checking
     * their segments for intersections.
     *
     * @throws InvalidGeometryException
     */
    private function intersectsGeometry(GeometryLinesInterface $geometry1, GeometryLinesInterface $geometry2): bool
    {
        if ($geometry1 instanceof Coordinate && $geometry2 instanceof Coordinate) {
            return $geometry1->hasSameLocation($geometry2);
        }

        if ($geometry1 instanceof Coordinate || $geometry2 instanceof Coordinate) {
            throw new InvalidGeometryException('Only can check point intersections for polygons', 7311194789);
        }

        if (($geometry1 instanceof Polygon) && $geometry1->containsGeometry($geometry2)) {
            return true;
        }

        if (($geometry2 instanceof Polygon) && $geometry2->containsGeometry($geometry1)) {
            return true;
        }

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
