<?php

namespace Location;

use Location\Distance\Vincenty;

class PolygonTest extends \PHPUnit_Framework_TestCase
{
    public function testIfAddPointsWorksAsExpected()
    {
        $polygon = new Polygon();

        $this->assertEquals([], $polygon->getPoints());

        $point1 = new Coordinate(10, 10);
        $polygon->addPoint($point1);

        $this->assertEquals([$point1], $polygon->getPoints());

        $point2 = new Coordinate(10, 20);
        $polygon->addPoint($point2);

        $this->assertEquals([$point1, $point2], $polygon->getPoints());
    }

    public function testIfGetNumberOfPointsWorksAsExpected()
    {
        $polygon = new Polygon();

        $this->assertEquals(0, $polygon->getNumberOfPoints());

        $polygon->addPoint(new Coordinate(10, 10));

        $this->assertEquals(1, $polygon->getNumberOfPoints());

        $polygon->addPoint(new Coordinate(10, 20));

        $this->assertEquals(2, $polygon->getNumberOfPoints());
    }

    public function testIfGetSegmentsWorksAsExpected()
    {
        $polygon = new Polygon();

        $point1 = new Coordinate(10, 20);
        $point2 = new Coordinate(10, 40);
        $point3 = new Coordinate(30, 40);
        $point4 = new Coordinate(30, 20);
        $polygon->addPoint($point1);
        $polygon->addPoint($point2);
        $polygon->addPoint($point3);
        $polygon->addPoint($point4);

        $expected = [
            new Line($point1, $point2),
            new Line($point2, $point3),
            new Line($point3, $point4),
            new Line($point4, $point1),
        ];

        $this->assertEquals($expected, $polygon->getSegments());
    }

    public function testIfGetLatsWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(10, 20));
        $polygon->addPoint(new Coordinate(10, 40));
        $polygon->addPoint(new Coordinate(30, 40));
        $polygon->addPoint(new Coordinate(30, 20));

        $expected = [10, 10, 30, 30];

        $this->assertEquals($expected, $polygon->getLats());
    }

    public function testIfGetLngsWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(10, 20));
        $polygon->addPoint(new Coordinate(10, 40));
        $polygon->addPoint(new Coordinate(30, 40));
        $polygon->addPoint(new Coordinate(30, 20));

        $expected = [20, 40, 40, 20];

        $this->assertEquals($expected, $polygon->getLngs());
    }

    public function testIfContainsPointCheckWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(10, 20));
        $polygon->addPoint(new Coordinate(10, 40));
        $polygon->addPoint(new Coordinate(30, 40));
        $polygon->addPoint(new Coordinate(30, 20));

        $point = new Coordinate(20, 30);

        $this->assertTrue($polygon->contains($point));
    }

    public function testIfContainsPointCheckWithLatitudeSignSwitchWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(- 30, 20));
        $polygon->addPoint(new Coordinate(- 30, 40));
        $polygon->addPoint(new Coordinate(30, 40));
        $polygon->addPoint(new Coordinate(30, 20));

        $point = new Coordinate(0, 30);
        $this->assertTrue($polygon->contains($point));

        $point = new Coordinate(- 10, 30);
        $this->assertTrue($polygon->contains($point));

        $point = new Coordinate(10, 30);
        $this->assertTrue($polygon->contains($point));
    }

    public function testIfContainsPointCheckWithLongitudeSignSwitchWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(10, - 20));
        $polygon->addPoint(new Coordinate(10, 40));
        $polygon->addPoint(new Coordinate(30, 40));
        $polygon->addPoint(new Coordinate(30, - 20));

        $point = new Coordinate(20, 0);
        $this->assertTrue($polygon->contains($point));

        $point = new Coordinate(20, - 10);
        $this->assertTrue($polygon->contains($point));

        $point = new Coordinate(20, 10);
        $this->assertTrue($polygon->contains($point));
    }

    public function testIfNotContainsPointCheckWithWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(10, 20));
        $polygon->addPoint(new Coordinate(10, 40));
        $polygon->addPoint(new Coordinate(30, 40));
        $polygon->addPoint(new Coordinate(30, 20));

        $point = new Coordinate(20, 10);
        $this->assertFalse($polygon->contains($point));

        $point = new Coordinate(20, 50);
        $this->assertFalse($polygon->contains($point));

        $point = new Coordinate(0, 30);
        $this->assertFalse($polygon->contains($point));

        $point = new Coordinate(40, 30);
        $this->assertFalse($polygon->contains($point));
    }

    /*
    public function testIfContainsPointCheckWithLongitudesCrossingThe180thMeridianWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(10, 150));
        $polygon->addPoint(new Coordinate(10, -150));
        $polygon->addPoint(new Coordinate(30, -150));
        $polygon->addPoint(new Coordinate(30, 150));

        $point = new Coordinate(20, 160);
        $this->assertTrue($polygon->contains($point));

        $point = new Coordinate(20, -160);
        $this->assertTrue($polygon->contains($point));
    }
    */

    public function testIfPerimeterCalculationWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(10, 10));
        $polygon->addPoint(new Coordinate(10, 20));
        $polygon->addPoint(new Coordinate(20, 20));
        $polygon->addPoint(new Coordinate(20, 10));

        // http://geographiclib.sourceforge.net/cgi-bin/Planimeter?type=polygon&rhumb=geodesic&input=10+10%0D%0A10+20%0D%0A20+20%0D%0A20+10&norm=decdegrees&option=Submit
        $this->assertEquals(4355689.472548, $polygon->getPerimeter(new Vincenty()), '', 0.01);

        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52, 13));
        $polygon->addPoint(new Coordinate(53, 13));
        $polygon->addPoint(new Coordinate(53, 12));
        $polygon->addPoint(new Coordinate(52, 12));

        // http://geographiclib.sourceforge.net/cgi-bin/Planimeter?type=polygon&rhumb=geodesic&input=52+13%0D%0A53+13%0D%0A53+12%0D%0A52+12&norm=decdegrees&option=Submit
        $this->assertEquals(358367.809428, $polygon->getPerimeter(new Vincenty()), '', 0.01);
    }

    /*
    public function testIfAreaCalculationWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52, 13));
        $polygon->addPoint(new Coordinate(53, 13));
        $polygon->addPoint(new Coordinate(53, 12));
        $polygon->addPoint(new Coordinate(52, 12));

        // http://geographiclib.sourceforge.net/cgi-bin/Planimeter?type=polygon&rhumb=geodesic&input=52.00000000000000000+13.00000000000000000%0D%0A53.00000000000000000+13.00000000000000000%0D%0A53.00000000000000000+12.00000000000000000%0D%0A52.00000000000000000+12.00000000000000000&norm=decdegrees&option=Submit
        $this->assertEquals(7556565706.2, $polygon->getArea(), 0.01);
    }
    */
}
