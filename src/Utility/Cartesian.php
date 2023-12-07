<?php

declare(strict_types=1);

namespace Location\Utility;

class Cartesian
{
    public function __construct(public readonly float $x, public readonly float $y, public readonly float $z)
    {
    }

    /**
     * @deprecated Use property instead
     */
    public function getX(): float
    {
        return $this->x;
    }

    /**
     * @deprecated Use property instead
     */
    public function getY(): float
    {
        return $this->y;
    }

    /**
     * @deprecated Use property instead
     */
    public function getZ(): float
    {
        return $this->z;
    }

    public function add(Cartesian $other): Cartesian
    {
        return new self(
            $this->x + $other->x,
            $this->y + $other->y,
            $this->z + $other->z
        );
    }
}
