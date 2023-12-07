<?php

declare(strict_types=1);

namespace Location\Factory;

use Location\GeometryInterface;

interface GeometryFactoryInterface
{
    public static function fromString(string $string): GeometryInterface;
}
