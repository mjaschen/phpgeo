<?php
declare(strict_types=1);

/**
 * Interface for simplifying a polyline
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */

namespace Location\Processor\Polyline;

use Location\Polyline;

/**
 * Interface for simplifying a polyline
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */
interface SimplifyInterface
{
    /**
     * Simplifies the given polyline
     *
     * @param \Location\Polyline $polyline
     *
     * @return Polyline
     */
    public function simplify(Polyline $polyline): Polyline;
}
