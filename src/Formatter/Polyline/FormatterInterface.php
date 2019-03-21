<?php
declare(strict_types=1);

/**
 * Polyline Formatter Interface
 *
 * @author    Richard Barnes <rbarnes@umn.edu>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Polyline;

use Location\Polyline;

/**
 * Polyline Formatter Interface
 *
 * @author   Richard Barnes <rbarnes@umn.edu>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */
interface FormatterInterface
{
    /**
     * @param Polyline $polyline
     *
     * @return string
     */
    public function format(Polyline $polyline): string;
}
