<?php

declare(strict_types=1);

namespace Location\Bearing;

use Location\Coordinate;

class DirectVincentyBearing
{
    public function __construct(public readonly Coordinate $destination, public readonly float $bearingFinal)
    {
    }

    /**
     * @deprecated use public attribute instead
     */
    public function getDestination(): Coordinate
    {
        return $this->destination;
    }

    /**
     * @deprecated use public attribute instead
     */
    public function getBearingFinal(): float
    {
        return $this->bearingFinal;
    }
}
