<?php
/**
 * Polyline Formatter Interface
 *
 * @author    Richard Barnes <rbarnes@umn.edu>
 * @license   https://opensource.org/licenses/GPL-3.0 GPL
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Polyline;

use Location\Polyline;

/**
 * Polyline Formatter Interface
 *
 * @author   Richard Barnes <rbarnes@umn.edu>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
interface FormatterInterface
{
    /**
     * @param Polyline $polyline
     *
     * @return mixed
     */
    public function format(Polyline $polyline);
}
