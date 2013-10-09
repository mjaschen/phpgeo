<?php
/**
 * GeoJSON Polyline Formatter
 *
 * PHP version 5.3
 *
 * @category  Location
 * @package   Formatter
 * @author    Richard Barnes <rbarnes@umn.edu>
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Polyline;

use Location\Polyline;

/**
 * GeoJSON Polyline Formatter
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
     * @param \Location\Polyline $polyline
     *
     * @return string
     */
    public function format(Polyline $polyline)
    {
        $points = array();

        foreach ($polyline->getPoints() as $point) {
            $points[] = array($point->getLng(), $point->getLat());
        }

        return json_encode(
            array(
                'type'        => 'LineString',
                'coordinates' => $points,
            )
        );
    }
}
