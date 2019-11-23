<?php

declare(strict_types=1);

namespace Location\Formatter\Coordinate;

use InvalidArgumentException;
use Location\Coordinate;

/**
 * Coordinate Formatter "DMS"
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
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
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $unitType;

    /**
     * @var array
     */
    protected $units = [
        'UTF-8' => [
            'deg' => '°',
            'min' => '′',
            'sec' => '″',
        ],
        'ASCII' => [
            'deg' => '°',
            'min' => '\'',
            'sec' => '"',
        ],
    ];

    /**
     * @param string $separator
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $separator = ' ')
    {
        $this->separator          = $separator;
        $this->useCardinalLetters = false;
        $this->setUnits(static::UNITS_UTF8);
    }

    /**
     * Sets the separator between latitude and longitude values
     *
     * @param string $separator
     *
     * @return DMS
     */
    public function setSeparator(string $separator): DMS
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * @param bool $value
     *
     * @return DMS
     */
    public function useCardinalLetters(bool $value): DMS
    {
        $this->useCardinalLetters = $value;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return DMS
     * @throws \InvalidArgumentException
     */
    public function setUnits(string $type): DMS
    {
        if (! array_key_exists($type, $this->units)) {
            throw new InvalidArgumentException('Invalid unit type');
        }

        $this->unitType = $type;

        return $this;
    }

    /**
     * @param Coordinate $coordinate
     *
     * @return string
     */
    public function format(Coordinate $coordinate): string
    {
        $lat = $coordinate->getLat();
        $lng = $coordinate->getLng();

        $latValue   = abs($lat);
        $latDegrees = (int)$latValue;

        $latMinutesDecimal = $latValue - $latDegrees;
        $latMinutes        = (int)(60 * $latMinutesDecimal);

        $latSeconds = 60 * (60 * $latMinutesDecimal - $latMinutes);

        $lngValue   = abs($lng);
        $lngDegrees = (int)$lngValue;

        $lngMinutesDecimal = $lngValue - $lngDegrees;
        $lngMinutes        = (int)(60 * $lngMinutesDecimal);

        $lngSeconds = 60 * (60 * $lngMinutesDecimal - $lngMinutes);

        return sprintf(
            '%s%02d%s %02d%s %02d%s%s%s%s%03d%s %02d%s %02d%s%s',
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
     * @param float $lat
     *
     * @return string
     */
    protected function getLatPrefix(float $lat): string
    {
        if ($this->useCardinalLetters || $lat >= 0) {
            return '';
        }

        return '-';
    }

    /**
     * @param float $lng
     *
     * @return string
     */
    protected function getLngPrefix(float $lng): string
    {
        if ($this->useCardinalLetters || $lng >= 0) {
            return '';
        }

        return '-';
    }

    /**
     * @param float $lat
     *
     * @return string
     */
    protected function getLatSuffix(float $lat): string
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
     * @param float $lng
     *
     * @return string
     */
    protected function getLngSuffix(float $lng): string
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
