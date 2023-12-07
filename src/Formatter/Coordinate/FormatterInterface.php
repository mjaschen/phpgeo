<?php

declare(strict_types=1);

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

interface FormatterInterface
{
    public function format(Coordinate $coordinate): string;
}
