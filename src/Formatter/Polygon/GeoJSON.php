<?php

declare(strict_types=1);

namespace Location\Formatter\Polygon;

use Location\Coordinate;
use Location\Exception\InvalidPolygonException;
use Location\Polygon;

/**
 * GeoJSON Polygon Formatter
 *
 * @author Richard Barnes <rbarnes@umn.edu>
 */
class GeoJSON implements FormatterInterface
{
    /**
     * @param Polygon $polygon
     *
     * @return string
     *
     * @throws InvalidPolygonException
     */
    public function format(Polygon $polygon): string
    {
        if ($polygon->getNumberOfPoints() < 3) {
            throw new InvalidPolygonException('A polygon must consist of at least three points.');
        }

        $points = [];

        /** @var Coordinate $point */
        foreach ($polygon->getPoints() as $point) {
            $points[] = [$point->getLng(), $point->getLat()];
        }

        return json_encode(
            [
                'type' => 'Polygon',
                'coordinates' => [$points],
            ]
        );
    }
}
