<?php

declare(strict_types=1);

namespace Location\Utility;

use PHPUnit\Framework\TestCase;

class CartesianTest extends TestCase
{
    private $point;

    public function setUp(): void
    {
        $this->point = new Cartesian(1.0, 2.0, 3.0);
    }

    public function testGetX(): void
    {
        $this->assertEquals(1.0, $this->point->getX());
    }

    public function testGetZ(): void
    {
        $this->assertEquals(3.0, $this->point->getZ());
    }

    public function testGetY(): void
    {
        $this->assertEquals(2.0, $this->point->getY());
    }

    public function testAdd(): void
    {
        $expected = new Cartesian(4.0, 5.0, 6.0);

        $this->assertEquals($expected, $this->point->add(new Cartesian(3.0, 3.0, 3.0)));
    }
}
