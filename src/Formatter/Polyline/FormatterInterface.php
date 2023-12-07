<?php

declare(strict_types=1);

namespace Location\Formatter\Polyline;

use Location\Polyline;

interface FormatterInterface
{
    public function format(Polyline $polyline): string;
}
