<?php

declare(strict_types=1);

namespace Location;

use Location\Coordinate;
use Location\Bounds;
use PHPUnit\Framework\TestCase;

class BoundsTest extends TestCase
{
    /**
     * @var Bounds
     */
    protected $object;

    protected function setUp(): void
    {
        $this->object = new Bounds(
            new Coordinate(50, 10),
            new Coordinate(30, 30)
        );
    }

    protected function tearDown(): void
    {
        unset($this->object);
    }

    public function testGetNortWest(): void
    {
        $c = new Coordinate(50, 10);

        $this->assertEquals($c, $this->object->getNorthWest());
    }

    public function testGetSouthEast(): void
    {
        $c = new Coordinate(30, 30);

        $this->assertEquals($c, $this->object->getSouthEast());
    }

    public function testGetNorth(): void
    {
        $this->assertEquals(50, $this->object->getNorth());
    }

    public function testGetSouth(): void
    {
        $this->assertEquals(30, $this->object->getSouth());
    }

    public function testGetWest(): void
    {
        $this->assertEquals(10, $this->object->getWest());
    }

    public function testGetEast(): void
    {
        $this->assertEquals(30, $this->object->getEast());
    }

    public function testGetCenter(): void
    {
        $testBounds = [
            ['nw' => new Coordinate(50, 10), 'se' => new Coordinate(30, 30), 'c' => new Coordinate(40, 20)],
            ['nw' => new Coordinate(50, - 130), 'se' => new Coordinate(30, - 110), 'c' => new Coordinate(40, - 120)],
            ['nw' => new Coordinate(10, - 10), 'se' => new Coordinate(- 10, 10), 'c' => new Coordinate(0, 0)],
            [
                'nw' => new Coordinate(- 80, - 130),
                'se' => new Coordinate(- 90, - 110),
                'c'  => new Coordinate(- 85, - 120)
            ],
            ['nw' => new Coordinate(80, - 130), 'se' => new Coordinate(90, - 110), 'c' => new Coordinate(85, - 120)],
            ['nw' => new Coordinate(80, 110), 'se' => new Coordinate(90, 130), 'c' => new Coordinate(85, 120)],
            ['nw' => new Coordinate(50, 170), 'se' => new Coordinate(30, - 160), 'c' => new Coordinate(40, - 175)],
            ['nw' => new Coordinate(- 50, 150), 'se' => new Coordinate(- 70, - 170), 'c' => new Coordinate(- 60, 170)],
        ];

        foreach ($testBounds as $bounds) {
            $b = new Bounds($bounds['nw'], $bounds['se']);

            $this->assertEquals($bounds['c'], $b->getCenter());
        }
    }
}
