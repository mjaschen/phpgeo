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
 * @link      http://r03.org/
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
 * @link     http://r03.org/
 */
class GeoJSON implements FormatterInterface
{
    /**
     * @param Coordinate $coordinate
     *
     * @return string
     */
    public function format(Polyline $polyline)
    {
        $ppoints=$polyline->getPoints();
        foreach($ppoints as &$p){
          $p=array($p->getLng(),$p->getLat());
        }
        return json_encode(
            array(
                'type'        => 'LineString',
                'coordinates' => $ppoints #array_slice($ppoints,0,200)
            )
        );
    }
}
