<?php
/**
 * Polygon Formatter Interface
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @author    Richard Barnes <rbarnes@umn.edu>
 * @license   https://opensource.org/licenses/GPL-3.0 GPL
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Polygon;

use Location\Polygon;

/**
 * Polygon Formatter Interface
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @author   Richard Barnes <rbarnes@umn.edu>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
interface FormatterInterface
{
    /**
     * @param Polygon $polygon
     *
     * @return mixed
     */
    public function format(Polygon $polygon);
}
