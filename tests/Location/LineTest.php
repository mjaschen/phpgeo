<?php

namespace Location;

use Location\Distance\Vincenty;

class LineTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateLine()
    {
        $point1 = new Coordinate(52.5, 13.5);
        $point2 = new Coordinate(64.1, -21.9);

        $line = new Line($point1, $point2);

        $this->assertEquals($point1, $line->getPoint1());
        $this->assertEquals($point2, $line->getPoint2());
    }

    public function testCalculateLength()
    {
        $point1 = new Coordinate(52.5, 13.5);
        $point2 = new Coordinate(64.1, -21.9);

        $line = new Line($point1, $point2);

        $this->assertEquals(2397867.8, $line->getLength(new Vincenty()), '', 0.01);
    }
}
