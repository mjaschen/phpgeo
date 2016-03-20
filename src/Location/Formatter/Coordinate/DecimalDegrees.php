<?php
/**
 * Coordinate Formatter "Decimal Degrees"
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @license   https://opensource.org/licenses/GPL-3.0 GPL
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

/**
 * Coordinate Formatter "Decimal Degrees"
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
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
