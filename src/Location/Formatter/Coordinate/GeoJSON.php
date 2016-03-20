<?php
/**
 * GeoJSON Coordinate Formatter
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @license   https://opensource.org/licenses/GPL-3.0 GPL
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

/**
 * GeoJSON Coordinate Formatter
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
class GeoJSON implements FormatterInterface
{
    /**
     * @param Coordinate $coordinate
     *
     * @return string
     */
    public function format(Coordinate $coordinate)
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
