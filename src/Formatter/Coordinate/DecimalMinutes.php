<?php

declare(strict_types=1);

namespace Location\Formatter\Coordinate;

use InvalidArgumentException;
use Location\Coordinate;

class DecimalMinutes implements FormatterInterface
{
    final public const UNITS_UTF8 = 'UTF-8';
    final public const UNITS_ASCII = 'ASCII';

    /**
     * Use cardinal letters for N/S and W/E instead of minus sign
     */
    protected bool $useCardinalLetters = false;

    protected string $unitType;

    protected int $digits = 3;

    protected string $decimalPoint = '.';

    /**
     * @var array{'UTF-8': array{deg: string, min: string}, 'ASCII': array{deg: string, min: string}}
     */
    protected array $units = [
        'UTF-8' => [
            'deg' => '°',
            'min' => '′',
        ],
        'ASCII' => [
            'deg' => '°',
            'min' => '\'',
        ],
    ];

    public function __construct(protected string $separator = ' ')
    {
        $this->setUnits(self::UNITS_UTF8);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function setUnits(string $type): DecimalMinutes
    {
        if (!array_key_exists($type, $this->units)) {
            throw new InvalidArgumentException('Invalid unit type');
        }

        $this->unitType = $type;

        return $this;
    }

    /**
     * Sets the separator between latitude and longitude values
     *
     * @deprecated Use the constructor instead
     */
    public function setSeparator(string $separator): DecimalMinutes
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * @return DecimalMinutes
     */
    public function useCardinalLetters(bool $value): DecimalMinutes
    {
        $this->useCardinalLetters = $value;

        return $this;
    }

    public function getUnitType(): string
    {
        return $this->unitType;
    }

    public function setDigits(int $digits): DecimalMinutes
    {
        $this->digits = $digits;

        return $this;
    }

    public function setDecimalPoint(string $decimalPoint): DecimalMinutes
    {
        $this->decimalPoint = $decimalPoint;

        return $this;
    }

    public function format(Coordinate $coordinate): string
    {
        $lat = $coordinate->getLat();
        $lng = $coordinate->getLng();

        $latValue = abs($lat);
        $latDegrees = (int)$latValue;

        $latMinutesDecimal = $latValue - $latDegrees;
        $latMinutes = 60 * $latMinutesDecimal;

        $lngValue = abs($lng);
        $lngDegrees = (int)$lngValue;

        $lngMinutesDecimal = $lngValue - $lngDegrees;
        $lngMinutes = 60 * $lngMinutesDecimal;

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

    protected function getLatPrefix(float $lat): string
    {
        if ($this->useCardinalLetters || $lat >= 0) {
            return '';
        }

        return '-';
    }

    protected function getLatSuffix(float $lat): string
    {
        if (!$this->useCardinalLetters) {
            return '';
        }

        if ($lat >= 0) {
            return ' N';
        }

        return ' S';
    }

    protected function getLngPrefix(float $lng): string
    {
        if ($this->useCardinalLetters || $lng >= 0) {
            return '';
        }

        return '-';
    }

    protected function getLngSuffix(float $lng): string
    {
        if (!$this->useCardinalLetters) {
            return '';
        }

        if ($lng >= 0) {
            return ' E';
        }

        return ' W';
    }
}
