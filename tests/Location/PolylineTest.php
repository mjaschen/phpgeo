<?php

namespace Location;

use Location\Distance\Vincenty;

class PolylineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Location\Polyline
     */
    protected $polyline;

    public function setUp()
    {
        $this->polyline = new Polyline();
        $this->polyline->addPoint(new Coordinate(52.5, 13.5));
        $this->polyline->addPoint(new Coordinate(64.1, - 21.9));
        $this->polyline->addPoint(new Coordinate(40.7, - 74.0));
        $this->polyline->addPoint(new Coordinate(33.9, - 118.4));
    }

    public function testCreatePolyline()
    {
        $this->assertCount(4, $this->polyline->getPoints());
    }

    public function testGetSegments()
    {
        $segments = $this->polyline->getSegments();

        $this->assertEquals(new Line(new Coordinate(52.5, 13.5), new Coordinate(64.1, - 21.9)), $segments[0]);
        $this->assertEquals(new Line(new Coordinate(64.1, - 21.9), new Coordinate(40.7, - 74.0)), $segments[1]);
        $this->assertEquals(new Line(new Coordinate(40.7, - 74.0), new Coordinate(33.9, - 118.4)), $segments[2]);
    }

    public function testGetLength()
    {
        $this->assertEquals(10576798.9, $this->polyline->getLength(new Vincenty()), '', 0.1);
    }

    public function testGetReverseWorksAsExpected()
    {
        $reversed = $this->polyline->getReverse();

        $expected = new Polyline();
        $expected->addPoint(new Coordinate(33.9, - 118.4));
        $expected->addPoint(new Coordinate(40.7, - 74.0));
        $expected->addPoint(new Coordinate(64.1, - 21.9));
        $expected->addPoint(new Coordinate(52.5, 13.5));

        $this->assertEquals($expected, $reversed);
    }

    public function testReverseTwiceWorksAsExpected()
    {
        $doubleReversed = $this->polyline->getReverse()->getReverse();

        $this->assertEquals($this->polyline, $doubleReversed);
    }
}
