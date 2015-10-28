<?php
/**
 * GeoJSON Polygon Formatter
 *
 * PHP version 5.3
 *
 * @category  Location
 * @package   Formatter
 * @author    Richard Barnes <rbarnes@umn.edu>
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Polygon;

use Location\Polygon;

/**
 * GeoJSON Polygon Formatter
 *
 * @category Location
 * @package  Formatter
 * @author   Richard Barnes <rbarnes@umn.edu>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
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
        $points = array();

        foreach ($polygon->getPoints() as $point) {
            $points[] = array($point->getLng(), $point->getLat());
        }

        return json_encode(
            array(
                'type'        => 'Polygon',
                'coordinates' => $points,
            )
        );
    }
}
