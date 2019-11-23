<?php

declare(strict_types=1);

namespace Location\Bearing;

/**
 * Value object for a "Direct Vincenty" bearing calculation result.
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class InverseVincentyBearing
{
    /**
     * @var float
     */
    private $distance;

    /**
     * @var float
     */
    private $bearingInitial;

    /**
     * @var float
     */
    private $bearingFinal;

    /**
     * InverseVincentyBearing constructor.
     *
     * @param float $distance
     * @param float $bearingInitial
     * @param float $bearingFinal
     */
    public function __construct(float $distance, float $bearingInitial, float $bearingFinal)
    {
        $this->distance       = $distance;
        $this->bearingInitial = $bearingInitial;
        $this->bearingFinal   = $bearingFinal;
    }

    /**
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * @return float
     */
    public function getBearingInitial(): float
    {
        return $this->bearingInitial;
    }

    /**
     * @return float
     */
    public function getBearingFinal(): float
    {
        return $this->bearingFinal;
    }
}
