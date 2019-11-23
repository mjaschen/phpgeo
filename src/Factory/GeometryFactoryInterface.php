<?php

declare(strict_types=1);

namespace Location\Factory;

use Location\GeometryInterface;

/**
 * Geometry Factory Interface
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
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
