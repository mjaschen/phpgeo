<?php
/**
 * Coordinate Formatter Interface
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @license   https://opensource.org/licenses/GPL-3.0 GPL
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

/**
 * Coordinate Formatter Interface
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
interface FormatterInterface
{
    /**
     * @param Coordinate $coordinate
     *
     * @return mixed
     */
    public function format(Coordinate $coordinate);
}
