<?php

declare(strict_types=1);

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

/**
 * Coordinate Formatter Interface
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
interface FormatterInterface
{
    /**
     * @param Coordinate $coordinate
     *
     * @return string
     */
    public function format(Coordinate $coordinate): string;
}
