<?php

namespace Location;

use Location\Coordinate;
use Location\Bounds;

class BoundsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Bounds
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Bounds(
            new Coordinate(50, 10),
            new Coordinate(30, 30)
        );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    /**
     * @covers Location\Bounds::getNorthWest
     */
    public function testGetNortWest()
    {
        $c = new Coordinate(50, 10);

        $this->assertEquals($c, $this->object->getNorthWest());
    }

    /**
     * @covers Location\Bounds::getSouthEast
     */
    public function testGetSouthEast()
    {
        $c = new Coordinate(30, 30);

        $this->assertEquals($c, $this->object->getSouthEast());
    }

    /**
     * @covers Location\Bounds::getNorth
     */
    public function testGetNorth()
    {
        $this->assertEquals(50, $this->object->getNorth());
    }

    /**
     * @covers Location\Bounds::getSouth
     */
    public function testGetSouth()
    {
        $this->assertEquals(30, $this->object->getSouth());
    }

    /**
     * @covers Location\Bounds::getWest
     */
    public function testGetWest()
    {
        $this->assertEquals(10, $this->object->getWest());
    }

    /**
     * @covers Location\Bounds::getEast
     */
    public function testGetEast()
    {
        $this->assertEquals(30, $this->object->getEast());
    }

    /**
     * @covers Location\Bounds::getCenter
     */
    public function testGetCenter()
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
