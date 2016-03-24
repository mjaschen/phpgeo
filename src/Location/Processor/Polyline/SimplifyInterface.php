<?php
/**
 * Interface for simplifying a polyline
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */

namespace Location\Processor\Polyline;

use Location\Polyline;

/**
 * Interface for simplifying a polyline
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
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
    public function simplify(Polyline $polyline);
}
