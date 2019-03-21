<?php
declare(strict_types=1);

/**
 * Geometry Factory Interface
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */

namespace Location\Factory;

use Location\GeometryInterface;

/**
 * Geometry Factory Interface
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */
interface GeometryFactoryInterface
{
    /**
     * @param string $string
     *
     * @return GeometryInterface
     */
    public static function fromString(string $string);
}
