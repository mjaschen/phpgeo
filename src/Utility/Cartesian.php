<?php

declare(strict_types=1);

namespace Location\Utility;

class Cartesian
{
    /**
     * @var float
     */
    private $x;
    /**
     * @var float
     */
    private $y;
    /**
     * @var float
     */
    private $z;

    /**
     * Cartesian constructor.
     *
     * @param $x
     * @param $y
     * @param $z
     */
    public function __construct(float $x, float $y, float $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
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
     * @param Cartesian $other
     *
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
