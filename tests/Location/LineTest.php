<?php

namespace Location;

use Location\Distance\Vincenty;

class LineTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateLine()
    {
        $coordinate1 = new Coordinate(52.5, 13.5);
        $coordinate2 = new Coordinate(64.1, -21.9);

        $line = new Line($coordinate1, $coordinate2);

        $this->assertEquals($coordinate1, $line->getCoordinate1());
        $this->assertEquals($coordinate2, $line->getCoordinate2());
    }

    public function testCalculateLength()
    {
        $coordinate1 = new Coordinate(52.5, 13.5);
        $coordinate2 = new Coordinate(64.1, -21.9);

        $line = new Line($coordinate1, $coordinate2);

        $this->assertEquals(2397867.8, $line->getLength(new Vincenty()), '', 0.01);
    }
}
