<?php

declare(strict_types=1);

namespace Location\Utility;

class Cartesian
{
    /**
     * Cartesian constructor.
     *
     * @param $x
     * @param $y
     * @param $z
     */
    public function __construct(private readonly float $x, private readonly float $y, private readonly float $z)
    {
    }

    /**
     * @return float
     */
    public function getX(): float
    {
        return $this->x;
    }

    /**
     * @return float
     */
    public function getY(): float
    {
        return $this->y;
    }

    /**
     * @return float
     */
    public function getZ(): float
    {
        return $this->z;
    }

    /**
     * @return Cartesian
     */
    public function add(Cartesian $other): Cartesian
    {
        return new self(
            $this->x + $other->x,
            $this->y + $other->y,
            $this->z + $other->z
        );
    }
}
