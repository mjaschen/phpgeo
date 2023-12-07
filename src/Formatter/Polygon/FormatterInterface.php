<?php

declare(strict_types=1);

namespace Location\Formatter\Polygon;

use Location\Polygon;

interface FormatterInterface
{
    public function format(Polygon $polygon): string;
}
