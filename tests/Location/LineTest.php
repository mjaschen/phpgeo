<?php

declare(strict_types=1);

namespace Location;

use Location\Bearing\BearingEllipsoidal;
use Location\Distance\Vincenty;
use PHPUnit\Framework\TestCase;

class LineTest extends TestCase
{
    public function testCreateLine()
    {
        $point1 = new Coordinate(52.5, 13.5);
        $point2 = new Coordinate(64.1, - 21.9);

        $line = new Line($point1, $point2);

        $this->assertEquals($point1, $line->getPoint1());
        $this->assertEquals($point2, $line->getPoint2());
    }

    public function testCalculateLength()
    {
        $point1 = new Coordinate(52.5, 13.5);
        $point2 = new Coordinate(64.1, - 21.9);

        $line = new Line($point1, $point2);

        $this->assertEqualsWithDelta(2397867.8, $line->getLength(new Vincenty()), 0.01, '');
    }

    public function testGetReverseWorksAsExpected()
    {
        $point1 = new Coordinate(52.5, 13.5);
        $point2 = new Coordinate(64.1, - 21.9);

        $line = new Line($point1, $point2);
        $reversedLine = $line->getReverse();

        $expected = new Line($point2, $point1);

        $this->assertEquals($expected, $reversedLine);
    }

    public function testIfGetBearingWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, 10);

        $line = new Line($point1, $point2);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(90.0, $line->getBearing($bearingCalculator));
    }

    public function testIfGetFinalBearingWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, 10);

        $line = new Line($point1, $point2);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(90.0, $line->getFinalBearing($bearingCalculator));
    }

    public function testIfGetBearingReversedWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, 10);

        $line = new Line($point2, $point1);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(270.0, $line->getBearing($bearingCalculator));
    }

    public function testIfGetFinalBearingReversedWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, 10);

        $line = new Line($point2, $point1);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(270.0, $line->getFinalBearing($bearingCalculator));
    }

    public function testIfGetBoundsWorksAsExpected()
    {
        $point1 = new Coordinate(-10.0, 20.0);
        $point2 = new Coordinate(3.0, 10.0);

        $line = new Line($point2, $point1);

        $expected = new Bounds(new Coordinate(3.0, 10.0), new Coordinate(-10.0, 20.0));

        $this->assertEquals($expected, $line->getBounds());
    }

    public function testIfGetMidpointWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(10, 20);

        $line = new Line($point1, $point2);

        $expected = new Coordinate(5, 10);

        $this->assertEquals($expected, $line->getMidpoint());
    }
}
