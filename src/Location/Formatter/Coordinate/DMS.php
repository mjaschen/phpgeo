<?php
/**
 * Coordinate Formatter "DMS"
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
 * Coordinate Formatter "DMS"
 *
 * @category Location
 * @package  Formatter
 * @author   Marcus T. Jaschen <mjaschen@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://r03.org/
 */
class DMS implements FormatterInterface
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

    protected $units = array(
        'UTF-8' => array(
            'deg' => '°',
            'min' => '′',
            'sec' => '″',
        ),
        'ASCII' => array(
            'deg' => '°',
            'min' => '\'',
            'sec' => '"',
        ),
    );

    /**
     * @param string $separator
     */
    public function __construct($separator = " ")
    {
        $this->setSeparator($separator);
        $this->useCardinalLetters(false);
        $this->setUnits(self::UNITS_UTF8);
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

    /**
     * @param bool $value
     *
     * @return $this
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
        switch ($type) {
            case self::UNITS_UTF8:
                $this->unitType = self::UNITS_UTF8;
                break;
            case self::UNITS_ASCII:
                $this->unitType = self::UNITS_ASCII;
                break;
            default:
                throw new \InvalidArgumentException("Invalid unit type");
        }
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

        $latValue = abs($lat);
        $latDegrees = intval($latValue);

        $latMinutesDecimal = $latValue - $latDegrees;
        $latMinutes = intval(60 * $latMinutesDecimal);

        $latSeconds = 60 * (60 * $latMinutesDecimal - $latMinutes);

        $lngValue = abs($lng);
        $lngDegrees = intval($lngValue);

        $lngMinutesDecimal = $lngValue - $lngDegrees;
        $lngMinutes = intval(60 * $lngMinutesDecimal);

        $lngSeconds = 60 * (60 * $lngMinutesDecimal - $lngMinutes);

        return sprintf(
            "%s%02d%s %02d%s %02d%s%s%s%s%03d%s %02d%s %02d%s%s",
            $this->getLatPrefix($lat),
            abs($latDegrees),
            $this->units[$this->unitType]['deg'],
            $latMinutes,
            $this->units[$this->unitType]['min'],
            round($latSeconds, 0),
            $this->units[$this->unitType]['sec'],
            $this->getLatSuffix($lat),
            $this->separator,
            $this->getLngPrefix($lng),
            abs($lngDegrees),
            $this->units[$this->unitType]['deg'],
            $lngMinutes,
            $this->units[$this->unitType]['min'],
            round($lngSeconds, 0),
            $this->units[$this->unitType]['sec'],
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