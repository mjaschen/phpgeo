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

    public function testGetReverseWorksAsExpected()
    {
        $point1 = new Coordinate(52.5, 13.5);
        $point2 = new Coordinate(64.1, -21.9);

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
        $line = new Line(new Coordinate(0, 0), new Coordinate(10, 20));

        $this->assertEquals(5.07672, $line->getMidpoint()->getLat(), '', 0.0001);
        $this->assertEquals(9.92267, $line->getMidpoint()->getLng(), '', 0.0001);

        $line = new Line(new Coordinate(1, 1), new Coordinate(-2, -2));

        $this->assertEquals(-0.5, $line->getMidpoint()->getLat(), '', 0.001);
        $this->assertEquals(-0.5, $line->getMidpoint()->getLng(), '', 0.001);

        $line = new Line(new Coordinate(35, -90), new Coordinate(35.2, -90.4));

        $this->assertEquals(35.1, $line->getMidpoint()->getLat(), '', 0.001);
        $this->assertEquals(-90.2, $line->getMidpoint()->getLng(), '', 0.001);
    }

    public function testIfGetMidpointAcrossLongitudeBorderWorksAsExpected()
    {
        $line = new Line(new Coordinate(0.0, -179.0), new Coordinate(0.0, 179.0));
        $this->assertEquals(new Coordinate(0.0, -180.0), $line->getMidpoint());

        $line = new Line(new Coordinate(0.0, -178.0), new Coordinate(0.0, 179.0));
        $this->assertEquals(new Coordinate(0.0, -179.5), $line->getMidpoint());
    }

    public function testIfGetIntermediatePointWorksAsExpected()
    {
        $line = new Line(new Coordinate(0, 0), new Coordinate(0, 1));
        $this->assertEquals(new Coordinate(0, 0), $line->getIntermediatePoint(0.));
        $line = new Line(new Coordinate(0, 0), new Coordinate(0, 1));
        $this->assertEquals(new Coordinate(0, .5), $line->getIntermediatePoint(.5));
        $line = new Line(new Coordinate(0, 0), new Coordinate(0, 1));
        $this->assertEquals(new Coordinate(0, 1), $line->getIntermediatePoint(1.));
    }

    public function testIfGetIntermediatePointThrowsExceptionForAntipodes()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(5382449689);

        $line = new Line(new Coordinate(45, -45), new Coordinate(-45, 135));
        $line->getIntermediatePoint(.5);
    }
}
