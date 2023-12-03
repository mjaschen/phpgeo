<?php

declare(strict_types=1);

namespace Location\Bearing;

class InverseVincentyBearing
{
    public function __construct(
        public readonly float $distance,
        public readonly float $bearingInitial,
        public readonly float $bearingFinal
    ) {
    }

    /**
     * @deprecated use public attribute instead
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * @deprecated use public attribute instead
     */
    public function getBearingInitial(): float
    {
        return $this->bearingInitial;
    }

    /**
     * @deprecated use public attribute instead
     */
    public function getBearingFinal(): float
    {
        return $this->bearingFinal;
    }
}
