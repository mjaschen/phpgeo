<?php
declare(strict_types=1);

/**
 * GeoJSON Coordinate Formatter
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

/**
 * GeoJSON Coordinate Formatter
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */
class GeoJSON implements FormatterInterface
{
    /**
     * @param Coordinate $coordinate
     *
     * @return string
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
            ]
        );
    }
}
