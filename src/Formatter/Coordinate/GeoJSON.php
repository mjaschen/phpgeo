<?php

declare(strict_types=1);

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

class GeoJSON implements FormatterInterface
{
    /**
     * @throws \JsonException
     */
    public function format(Coordinate $coordinate): string
    {
        return json_encode(
            [
                'type'        => 'Point',
                'coordinates' => [
                    $coordinate->getLng(),
                    $coordinate->getLat(),
                ],
            ],
            JSON_THROW_ON_ERROR
        );
    }
}
