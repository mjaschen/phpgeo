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
     * @var int
     */
    protected $digits = 5;

    /**
     * @param string $separator
     * @param int $digits
     */
    public function __construct($separator = ' ', $digits = 5)
    {
        $this->setSeparator($separator);
        $this->digits = $digits;
    }

    /**
     * @param Coordinate $coordinate
     *
     * @return string
     */
    public function format(Coordinate $coordinate)
    {
        return sprintf("%.{$this->digits}f%s%.{$this->digits}f", $coordinate->getLat(), $this->separator, $coordinate->getLng());
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
