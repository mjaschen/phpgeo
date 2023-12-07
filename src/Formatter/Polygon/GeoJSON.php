<?php

declare(strict_types=1);

namespace Location\Formatter\Polygon;

use JsonException;
use Location\Exception\InvalidPolygonException;
use Location\Polygon;

class GeoJSON implements FormatterInterface
{
    /**
     * @throws InvalidPolygonException
     */
    public function format(Polygon $polygon): string
    {
        if ($polygon->getNumberOfPoints() < 3) {
            throw new InvalidPolygonException('A polygon must consist of at least three points.');
        }

        $points = [];

        foreach ($polygon->getPoints() as $point) {
            $points[] = [$point->getLng(), $point->getLat()];
        }

        return json_encode(
            [
                'type' => 'Polygon',
                'coordinates' => [$points],
            ],
            JSON_THROW_ON_ERROR
        );
    }
}
