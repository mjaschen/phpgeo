<?php
/**
 * Coordinate Formatter "Decimal Degrees"
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
 * Coordinate Formatter "Decimal Degrees"
 *
 * @category Location
 * @package  Formatter
 * @author   Marcus T. Jaschen <mjaschen@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://r03.org/
 */
class DecimalDegrees implements FormatterInterface
{
    /**
     * @var string Separator string between latitude and longitude
     */
    protected $separator;

    /**
     * @param string $separator
     */
    public function __construct($separator = " ")
    {
        $this->setSeparator($separator);
    }

    /**
     * @param Coordinate $coordinate
     *
     * @return string
     */
    public function format(Coordinate $coordinate)
    {
        return sprintf("%.5f%s%.5f", $coordinate->getLat(), $this->separator, $coordinate->getLng());
    }

    /**
     * Sets the separator between latitude and longitude values
     *
     * @param $separator
     *
     * @return $this
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }
}