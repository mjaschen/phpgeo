<?php
/**
 * GeoJSON Polygon Formatter
 *
 * @author    Richard Barnes <rbarnes@umn.edu>
 * @license   https://opensource.org/licenses/GPL-3.0 GPL
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Polygon;

use Location\Polygon;

/**
 * GeoJSON Polygon Formatter
 *
 * @author   Richard Barnes <rbarnes@umn.edu>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
class GeoJSON implements FormatterInterface
{
    /**
     * @param \Location\Polygon $polygon
     *
     * @return string
     */
    public function format(Polygon $polygon)
    {
        $points = [];

        foreach ($polygon->getPoints() as $point) {
            $points[] = [$point->getLng(), $point->getLat()];
        }

        return json_encode(
            [
                'type'        => 'Polygon',
                'coordinates' => $points,
            ]
        );
    }
}
