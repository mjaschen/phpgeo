<?php

declare(strict_types=1);

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

class DecimalDegrees implements FormatterInterface
{
    public function __construct(protected string $separator = ' ', protected int $digits = 5)
    {
    }

    public function format(Coordinate $coordinate): string
    {
        return sprintf(
            '%.' . $this->digits . 'f%s%.' . $this->digits . 'f',
            $coordinate->getLat(),
            $this->separator,
            $coordinate->getLng()
        );
    }

    /**
     * Sets the separator between latitude and longitude values
     *
     * @deprecated
     */
    public function setSeparator(string $separator): DecimalDegrees
    {
        $this->separator = $separator;

        return $this;
    }
}
