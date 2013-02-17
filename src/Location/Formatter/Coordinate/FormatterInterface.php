<?php
/**
 * Coordinate Formatter Interface
 *
 * PHP version 5
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
 * Coordinate Formatter Interface
 *
 * @category Location
 * @package  Formatter
 * @author   Marcus T. Jaschen <mjaschen@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://r03.org/
 */
interface FormatterInterface
{
    /**
     * @param Coordinate $coordinate
     *
     * @return mixed
     */
    public function format(Coordinate $coordinate);
}