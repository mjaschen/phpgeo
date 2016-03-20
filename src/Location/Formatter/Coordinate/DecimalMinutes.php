<?php
/**
 * Coordinate Formatter "DecimalMinutes"
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @license   https://opensource.org/licenses/GPL-3.0 GPL
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

/**
 * Coordinate Formatter "DecimalMinutes"
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
class DecimalMinutes implements FormatterInterface
{
    const UNITS_UTF8  = 'UTF-8';
    const UNITS_ASCII = 'ASCII';

    /**
     * @var string Separator string between latitude and longitude
     */
    protected $separator;

    /**
     * Use cardinal letters for N/S and W/E instead of minus sign
     *
     * @var bool
     */
    protected $useCardinalLetters;

    /**
     * @var string
     */
    protected $unitType;

    /**
     * @var int
     */
    protected $digits = 3;

    /**
     * @var string
     */
    protected $decimalPoint = '.';

    /**
     * @var array
     */
    protected $units = [
        'UTF-8' => [
            'deg' => '°',
            'min' => '′',
        ],
        'ASCII' => [
            'deg' => '°',
            'min' => '\'',
        ],
    ];

    /**
     * @param string $separator
     */
    public function __construct($separator = " ")
    {
        $this->setSeparator($separator);
        $this->useCardinalLetters(false);
        $this->setUnits(static::UNITS_UTF8);
    }

    /**
     * Sets the separator between latitude and longitude values
     *
     * @param $separator
     *
     * @return DecimalMinutes
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * @param bool $value
     *
     * @return DecimalMinutes
     */
    public function useCardinalLetters($value)
    {
        $this->useCardinalLetters = $value;

        return $this;
    }

    /**
     * @param string $type
     *
     * @throws \InvalidArgumentException
     */
    public function setUnits($type)
    {
        if (! array_key_exists($type, $this->units)) {
            throw new \InvalidArgumentException("Invalid unit type");
        }

        $this->unitType = $type;
    }

    /**
     * @param int $digits
     *
     * @return DecimalMinutes
     */
    public function setDigits($digits)
    {
        $this->digits = $digits;

        return $this;
    }

    /**
     * @param string $decimalPoint
     *
     * @return DecimalMinutes
     */
    public function setDecimalPoint($decimalPoint)
    {
        $this->decimalPoint = $decimalPoint;

        return $this;
    }

    /**
     * @param Coordinate $coordinate
     *
     * @return string
     */
    public function format(Coordinate $coordinate)
    {
        $lat = $coordinate->getLat();
        $lng = $coordinate->getLng();

        $latValue   = abs($lat);
        $latDegrees = intval($latValue);

        $latMinutesDecimal = $latValue - $latDegrees;
        $latMinutes        = 60 * $latMinutesDecimal;

        $lngValue   = abs($lng);
        $lngDegrees = intval($lngValue);

        $lngMinutesDecimal = $lngValue - $lngDegrees;
        $lngMinutes        = 60 * $lngMinutesDecimal;

        return sprintf(
            "%s%02d%s %s%s%s%s%s%03d%s %s%s%s",
            $this->getLatPrefix($lat),
            abs($latDegrees),
            $this->units[$this->unitType]['deg'],
            number_format($latMinutes, $this->digits, $this->decimalPoint, $this->decimalPoint),
            $this->units[$this->unitType]['min'],
            $this->getLatSuffix($lat),
            $this->separator,
            $this->getLngPrefix($lng),
            abs($lngDegrees),
            $this->units[$this->unitType]['deg'],
            number_format($lngMinutes, $this->digits, $this->decimalPoint, $this->decimalPoint),
            $this->units[$this->unitType]['min'],
            $this->getLngSuffix($lng)
        );
    }

    /**
     * @param $lat
     *
     * @return string
     */
    protected function getLatPrefix($lat)
    {
        if ($this->useCardinalLetters || $lat >= 0) {
            return '';
        }

        return '-';
    }

    /**
     * @param $lng
     *
     * @return string
     */
    protected function getLngPrefix($lng)
    {
        if ($this->useCardinalLetters || $lng >= 0) {
            return '';
        }

        return '-';
    }

    /**
     * @param $lat
     *
     * @return string
     */
    protected function getLatSuffix($lat)
    {
        if (! $this->useCardinalLetters) {
            return '';
        }

        if ($lat >= 0) {
            return ' N';
        }

        return ' S';
    }

    /**
     * @param $lng
     *
     * @return string
     */
    protected function getLngSuffix($lng)
    {
        if (! $this->useCardinalLetters) {
            return '';
        }

        if ($lng >= 0) {
            return ' E';
        }

        return ' W';
    }
}
