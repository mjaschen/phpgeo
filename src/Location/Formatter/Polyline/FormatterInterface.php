<?php
/**
 * Polyline Formatter Interface
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
 * Polyline Formatter Interface
 *
 * @category Location
 * @package  Formatter
 * @author   Richard Barnes <rbarnes@umn.edu>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://r03.org/
 */
interface FormatterInterface
{
    /**
     * @param Polyline $polyline
     *
     * @return mixed
     */
    public function format(Polyline $polyline);
}
