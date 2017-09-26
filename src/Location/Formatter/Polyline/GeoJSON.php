<?php
declare(strict_types=1);

/**
 * GeoJSON Polyline Formatter
 *
 * @author    Richard Barnes <rbarnes@umn.edu>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Polyline;

use Location\Polyline;

/**
 * GeoJSON Polyline Formatter
 *
 * @author   Richard Barnes <rbarnes@umn.edu>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */
class GeoJSON implements FormatterInterface
{
    /**
     * @param \Location\Polyline $polyline
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
