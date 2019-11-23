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
     * @var Coordinate
     */
    private $destination;

    /**
     * @var float
     */
    private $bearingFinal;

    /**
     * Bearing constructor.
     *
     * @param Coordinate $destination
     * @param float $bearingFinal
     */
    public function __construct(Coordinate $destination, float $bearingFinal)
    {
        $this->destination  = $destination;
        $this->bearingFinal = $bearingFinal;
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
