<?php

declare(strict_types=1);

namespace Location\Bearing;

use Location\Coordinate;

/**
 * Value object for a "Direct Vincenty" bearing calculation result.
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class DirectVincentyBearing
{
    /**
     * Bearing constructor.
     */
    public function __construct(private readonly Coordinate $destination, private readonly float $bearingFinal)
    {
    }

    /**
     * @return Coordinate
     */
    public function getDestination(): Coordinate
    {
        return $this->destination;
    }

    /**
     * @return float
     */
    public function getBearingFinal(): float
    {
        return $this->bearingFinal;
    }
}
