<?php
declare(strict_types=1);

/**
 * Polygon Formatter Interface
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @author    Richard Barnes <rbarnes@umn.edu>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Polygon;

use Location\Polygon;

/**
 * Polygon Formatter Interface
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @author   Richard Barnes <rbarnes@umn.edu>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */
interface FormatterInterface
{
    /**
     * @param Polygon $polygon
     *
     * @return string
     */
    public function format(Polygon $polygon): string;
}
