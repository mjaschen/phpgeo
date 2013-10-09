<?php
/**
 * GeoJSON Coordinate Formatter
 *
 * PHP version 5.3
 *
 * @category  Location
 * @package   Formatter
 * @author    Marcus T. Jaschen <mjaschen@gmail.com>
 * @copyright 2012 r03.org
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      http://r03.org/
 */

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

/**
 * GeoJSON Coordinate Formatter
 *
 * @category Location
 * @package  Formatter
 * @author   Marcus T. Jaschen <mjaschen@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://r03.org/
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
            array(
                'type'        => 'Point',
                'coordinates' => array(
                    $coordinate->getLng(),
                    $coordinate->getLat(),
                ),
            )
        );
    }
}