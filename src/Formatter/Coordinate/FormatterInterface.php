<?php
declare(strict_types=1);

/**
 * Coordinate Formatter Interface
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

/**
 * Coordinate Formatter Interface
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */
interface FormatterInterface
{
    /**
     * @param Coordinate $coordinate
     *
     * @return string
     */
    public function format(Coordinate $coordinate): string;
}
