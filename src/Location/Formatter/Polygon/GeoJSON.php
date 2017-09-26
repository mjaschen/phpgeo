<?php
declare(strict_types=1);

/**
 * GeoJSON Polygon Formatter
 *
 * @author    Richard Barnes <rbarnes@umn.edu>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Polygon;

use Location\Coordinate;
use Location\Exception\InvalidPolygonException;
use Location\Polygon;

/**
 * GeoJSON Polygon Formatter
 *
 * @author   Richard Barnes <rbarnes@umn.edu>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */
class GeoJSON implements FormatterInterface
{
    /**
     * @param \Location\Polygon $polygon
     *
     * @return string
     *
     * @throws \Location\Exception\InvalidPolygonException
     */
    public function format(Polygon $polygon): string
    {
        if ($polygon->getNumberOfPoints() < 3) {
            throw new InvalidPolygonException();
        }
        $points = [];

        /** @var Coordinate $point */
        foreach ($polygon->getPoints() as $point) {
            $points[] = [$point->getLng(), $point->getLat()];
        }

        return json_encode(
            [
                'type'        => 'Polygon',
                'coordinates' => [$points],
            ]
        );
    }
}
