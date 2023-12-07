<?php

declare(strict_types=1);

namespace Location\Formatter\Polyline;

use Location\Polyline;

class GeoJSON implements FormatterInterface
{
    /**
     * @throws \JsonException
     */
    public function format(Polyline $polyline): string
    {
        $points = [];

        foreach ($polyline->getPoints() as $point) {
            $points[] = [$point->getLng(), $point->getLat()];
        }

        return json_encode(
            [
                'type'        => 'LineString',
                'coordinates' => $points,
            ],
            JSON_THROW_ON_ERROR
        );
    }
}
