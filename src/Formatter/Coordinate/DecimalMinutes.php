<?php

declare(strict_types=1);

namespace Location\Formatter\Coordinate;

use InvalidArgumentException;
use Location\Coordinate;

/**
 * Coordinate Formatter "DecimalMinutes"
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class DecimalMinutes implements FormatterInterface
{
    public const UNITS_UTF8  = 'UTF-8';
    public const UNITS_ASCII = 'ASCII';

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
    public function __construct(string $separator = ' ')
    {
        $this->separator          = $separator;
        $this->useCardinalLetters = false;

        $this->setUnits(self::UNITS_UTF8);
    }

    /**
     * Sets the separator between latitude and longitude values
     *
     * @param string $separator
     *
     * @return DecimalMinutes
     */
    public function setSeparator(string $separator): DecimalMinutes
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * @param bool $value
     *
     * @return DecimalMinutes
     */
    public function useCardinalLetters(bool $value): DecimalMinutes
    {
        $this->useCardinalLetters = $value;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return DecimalMinutes
     * @throws \InvalidArgumentException
     */
    public function setUnits(string $type): DecimalMinutes
    {
        if (! array_key_exists($type, $this->units)) {
            throw new InvalidArgumentException('Invalid unit type');
        }

        $this->unitType = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnitType(): string
    {
        return $this->unitType;
    }

    /**
     * @param int $digits
     *
     * @return DecimalMinutes
     */
    public function setDigits(int $digits): DecimalMinutes
    {
        $this->digits = $digits;

        return $this;
    }

    /**
     * @param string $decimalPoint
     *
     * @return DecimalMinutes
     */
    public function setDecimalPoint(string $decimalPoint): DecimalMinutes
    {
        $this->decimalPoint = $decimalPoint;

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
        $latMinutes        = 60 * $latMinutesDecimal;

        $lngValue   = abs($lng);
        $lngDegrees = (int)$lngValue;

        $lngMinutesDecimal = $lngValue - $lngDegrees;
        $lngMinutes        = 60 * $lngMinutesDecimal;

        return sprintf(
            '%s%02d%s %s%s%s%s%s%03d%s %s%s%s',
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
