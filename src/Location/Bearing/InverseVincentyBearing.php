<?php
declare(strict_types=1);

/**
 * Value object for a "Inverse Vincenty" bearing calculation result.
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */

namespace Location\Bearing;

/**
 * Value object for a "Direct Vincenty" bearing calculation result.
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
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
