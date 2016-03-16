<?php
/**
 * Geometry Factory Interface
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */

namespace Location\Factory;

use Location\GeometryInterface;

/**
 * Geometry Factory Interface
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL
 * @link     https://github.com/mjaschen/phpgeo
 */
interface GeometryFactoryInterface
{
    /**
     * @param $string
     *
     * @return GeometryInterface
     */
    public static function fromString($string);
}
