<?php

declare(strict_types=1);

namespace Location\Processor\Polyline;

use Location\Polyline;

interface SimplifyInterface
{
    public function simplify(Polyline $polyline): Polyline;
}
