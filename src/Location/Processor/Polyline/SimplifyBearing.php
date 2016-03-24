<?php
/**
 * Simplify Polyline
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */

namespace Location\Processor\Polyline;

use Location\Polyline;

/**
 * Simplify Polyline
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
class SimplifyBearing implements SimplifyInterface
{
    /**
     * @var float
     */
    private $bearingAngle;

    /**
     * SimplifyBearing constructor.
     *
     * @param float $bearingAngle
     */
    public function __construct($bearingAngle)
    {
        $this->bearingAngle = $bearingAngle;
    }

    /**
     * Simplifies the given polyline
     *
     * @param Polyline $polyline
     *
     * @return Polyline
     */
    public function simplify(Polyline $polyline)
    {
        throw new \RuntimeException("Not implemented yet");
    }
}
