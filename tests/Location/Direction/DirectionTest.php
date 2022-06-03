<?php

declare(strict_types=1);

namespace Location\Direction;

use Location\Coordinate;
use PHPUnit\Framework\TestCase;

class DirectionTest extends TestCase
{
    public function testIsNorthOf(): void
    {
        $this->assertTrue((new Direction())->pointIsNorthOf(new Coordinate(50, 13), new Coordinate(40, 10)));
        $this->assertTrue((new Direction())->pointIsNorthOf(new Coordinate(-50, 13), new Coordinate(-60, 10)));
        $this->assertTrue((new Direction())->pointIsNorthOf(new Coordinate(10, 13), new Coordinate(-40, 10)));
    }

    public function testIsSouthOf(): void
    {
        $this->assertTrue((new Direction())->pointIsSouthOf(new Coordinate(40, 10), new Coordinate(50, 13)));
        $this->assertTrue((new Direction())->pointIsSouthOf(new Coordinate(-60, 10), new Coordinate(-50, 13)));
        $this->assertTrue((new Direction())->pointIsSouthOf(new Coordinate(-40, 10), new Coordinate(10, 13)));
    }

    public function testIsWestOf(): void
    {
        $this->assertTrue((new Direction())->pointIsWestOf(new Coordinate(40, 10), new Coordinate(50, 13)));
        $this->assertTrue((new Direction())->pointIsWestOf(new Coordinate(-60, -10), new Coordinate(-50, -3)));
        $this->assertTrue((new Direction())->pointIsWestOf(new Coordinate(-40, -100), new Coordinate(10, 130)));
        $this->assertTrue((new Direction())->pointIsWestOf(new Coordinate(-40, -179), new Coordinate(10, 179)));
    }

    public function testIsEastOf(): void
    {
        $this->assertTrue((new Direction())->pointIsEastOf(new Coordinate(50, 13), new Coordinate(40, 10)));
        $this->assertTrue((new Direction())->pointIsEastOf(new Coordinate(-50, -3), new Coordinate(-60, -10)));
        $this->assertTrue((new Direction())->pointIsEastOf(new Coordinate(10, 130), new Coordinate(-40, -100)));
        $this->assertTrue((new Direction())->pointIsEastOf(new Coordinate(10, 179), new Coordinate(-40, -179)));
    }
}
