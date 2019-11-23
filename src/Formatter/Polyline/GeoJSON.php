<?php

declare(strict_types=1);

namespace Location\Formatter\Polyline;

use Location\Polyline;

/**
 * GeoJSON Polyline Formatter
 *
 * @author Richard Barnes <rbarnes@umn.edu>
 */
class GeoJSON implements FormatterInterface
{
    /**
     * @param Polyline $polyline
     *
     * @return string
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
            ]
        );
    }
}
