<?php

declare(strict_types=1);

namespace Location\Formatter\Polyline;

use Location\Polyline;

/**
 * Polyline Formatter Interface
 *
 * @author Richard Barnes <rbarnes@umn.edu>
 */
interface FormatterInterface
{
    /**
     * @return string
     */
    public function format(Polyline $polyline): string;
}
