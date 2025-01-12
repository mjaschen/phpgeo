<?php

declare(strict_types=1);

namespace Location\Formatter\Coordinate;

use InvalidArgumentException;
use Location\Coordinate;

class DMS implements FormatterInterface
{
    final public const UNITS_UTF8 = 'UTF-8';
    final public const UNITS_ASCII = 'ASCII';

    /**
     * @var string Separator string between latitude and longitude
     */
    protected string $separator;

    /**
     * Use cardinal letters for N/S and W/E instead of minus sign
     */
    protected bool $useCardinalLetters;

    protected string $unitType;

    /**
     * @var array<string, array{deg: string, min: string, sec: string}>
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

    public function __construct(
        string $separator = ' ',
        bool $useCardinalLetters = false,
        string $unitType = self::UNITS_UTF8
    ) {
        $this->separator = $separator;
        $this->useCardinalLetters = $useCardinalLetters;
        $this->unitType = $unitType;
    }

    /**
     * Sets the separator between latitude and longitude values
     *
     * @deprecated use constructor instead
     */
    public function setSeparator(string $separator): DMS
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * @deprecated use constructor instead
     */
    public function useCardinalLetters(bool $value): DMS
    {
        $this->useCardinalLetters = $value;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     * @deprecated use constructor instead
     */
    public function setUnits(string $type): DMS
    {
        if (!array_key_exists($type, $this->units)) {
            throw new InvalidArgumentException('Invalid unit type');
        }

        $this->unitType = $type;

        return $this;
    }

    public function getUnitType(): string
    {
        return $this->unitType;
    }

    public function format(Coordinate $coordinate): string
    {
        $lat = $coordinate->getLat();
        $lng = $coordinate->getLng();

        $latValue = abs($lat);
        $latDegrees = (int)$latValue;

        $latMinutesDecimal = $latValue - $latDegrees;
        $latMinutes = (int)(60 * $latMinutesDecimal);

        $latSeconds = 60 * (60 * $latMinutesDecimal - $latMinutes);

        $lngValue = abs($lng);
        $lngDegrees = (int)$lngValue;

        $lngMinutesDecimal = $lngValue - $lngDegrees;
        $lngMinutes = (int)(60 * $lngMinutesDecimal);

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
