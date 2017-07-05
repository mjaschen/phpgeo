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

    public function testIfAreaCalculationWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(0.0000000000, 0.0000000000));
        $polygon->addPoint(new Coordinate(0.0000000000, 0.0008983153));
        $polygon->addPoint(new Coordinate(0.0009043695, 0.0008983153));
        $polygon->addPoint(new Coordinate(0.0009043695, 0.0000000000));

        // https://geographiclib.sourceforge.io/cgi-bin/Planimeter?type=polygon&rhumb=geodesic&input=0.0000000000+0.0000000000%0D%0A0.0000000000+0.0008983153%0D%0A0.0009043695+0.0008983153%0D%0A0.0009043695+0.0000000000&norm=decdegrees&option=Submit
        //$this->assertEquals(10000.0, $polygon->getArea(), '', 1.0);
    }

    public function testIfPolygonContainsGeometryWithPolygonInsideWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.221651719883084, 13.661613101139665));
        $polygon->addPoint(new Coordinate(52.215716242790222, 13.662988655269146));
        $polygon->addPoint(new Coordinate(52.211922844871879, 13.662990247830749));
        $polygon->addPoint(new Coordinate(52.208002796396613, 13.664533020928502));
        $polygon->addPoint(new Coordinate(52.203469779342413, 13.664621533825994));
        $polygon->addPoint(new Coordinate(52.199896154925227, 13.665583860129118));
        $polygon->addPoint(new Coordinate(52.199177406728268, 13.665664242580533));
        $polygon->addPoint(new Coordinate(52.197426510974765, 13.664221465587616));
        $polygon->addPoint(new Coordinate(52.196468207985163, 13.674150248989463));
        $polygon->addPoint(new Coordinate(52.200047867372632, 13.674412602558732));
        $polygon->addPoint(new Coordinate(52.203508755192161, 13.676183195784688));
        $polygon->addPoint(new Coordinate(52.206863863393664, 13.678688379004598));
        $polygon->addPoint(new Coordinate(52.213457236066461, 13.67043505422771));
        $polygon->addPoint(new Coordinate(52.217430174350739, 13.66775787435472));
        $polygon->addPoint(new Coordinate(52.221683654934168, 13.661622740328312));

        $insidePolygon = new Polygon();
        $insidePolygon->addPoint(new Coordinate(52.206110581755638, 13.674710914492607));
        $insidePolygon->addPoint(new Coordinate(52.202216433361173, 13.673997698351741));
        $insidePolygon->addPoint(new Coordinate(52.20279042609036, 13.666518358513713));
        $insidePolygon->addPoint(new Coordinate(52.209159163758159, 13.667042898014188));
        $insidePolygon->addPoint(new Coordinate(52.215381134301424, 13.664670567959547));
        $insidePolygon->addPoint(new Coordinate(52.209875900298357, 13.672981224954128));

        $this->assertTrue($polygon->containsGeometry($insidePolygon));
    }

    public function testIfPolygonContainsGeometryWithPolygonInsideAndOutsideWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.221651719883084, 13.661613101139665));
        $polygon->addPoint(new Coordinate(52.215716242790222, 13.662988655269146));
        $polygon->addPoint(new Coordinate(52.211922844871879, 13.662990247830749));
        $polygon->addPoint(new Coordinate(52.208002796396613, 13.664533020928502));
        $polygon->addPoint(new Coordinate(52.203469779342413, 13.664621533825994));
        $polygon->addPoint(new Coordinate(52.199896154925227, 13.665583860129118));
        $polygon->addPoint(new Coordinate(52.199177406728268, 13.665664242580533));
        $polygon->addPoint(new Coordinate(52.197426510974765, 13.664221465587616));
        $polygon->addPoint(new Coordinate(52.196468207985163, 13.674150248989463));
        $polygon->addPoint(new Coordinate(52.200047867372632, 13.674412602558732));
        $polygon->addPoint(new Coordinate(52.203508755192161, 13.676183195784688));
        $polygon->addPoint(new Coordinate(52.206863863393664, 13.678688379004598));
        $polygon->addPoint(new Coordinate(52.213457236066461, 13.67043505422771));
        $polygon->addPoint(new Coordinate(52.217430174350739, 13.66775787435472));
        $polygon->addPoint(new Coordinate(52.221683654934168, 13.661622740328312));

        $inAndOutSidePolygon = new Polygon();
        $inAndOutSidePolygon->addPoint(new Coordinate(52.206110581755638, 13.674710914492607));
        $inAndOutSidePolygon->addPoint(new Coordinate(52.202216433361173, 13.673997698351741));
        $inAndOutSidePolygon->addPoint(new Coordinate(52.20279042609036, 13.666518358513713));
        $inAndOutSidePolygon->addPoint(new Coordinate(52.209159163758159, 13.667042898014188));
        $inAndOutSidePolygon->addPoint(new Coordinate(52.215381134301424, 13.664670567959547));
        $inAndOutSidePolygon->addPoint(new Coordinate(52.209875900298357, 13.672981224954128));
        $inAndOutSidePolygon->addPoint(new Coordinate(52.211303086951375, 13.676270367577672));
        $inAndOutSidePolygon->addPoint(new Coordinate(52.20556978136301, 13.688599476590753));
        $inAndOutSidePolygon->addPoint(new Coordinate(52.205583276227117, 13.688599476590753));
        $inAndOutSidePolygon->addPoint(new Coordinate(52.204232113435864, 13.683774350211024));

        $this->assertFalse($polygon->containsGeometry($inAndOutSidePolygon));
    }

    public function testIfPolygonContainsGeometryWithPolygonOutsideWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.221651719883084, 13.661613101139665));
        $polygon->addPoint(new Coordinate(52.215716242790222, 13.662988655269146));
        $polygon->addPoint(new Coordinate(52.211922844871879, 13.662990247830749));
        $polygon->addPoint(new Coordinate(52.208002796396613, 13.664533020928502));
        $polygon->addPoint(new Coordinate(52.203469779342413, 13.664621533825994));
        $polygon->addPoint(new Coordinate(52.199896154925227, 13.665583860129118));
        $polygon->addPoint(new Coordinate(52.199177406728268, 13.665664242580533));
        $polygon->addPoint(new Coordinate(52.197426510974765, 13.664221465587616));
        $polygon->addPoint(new Coordinate(52.196468207985163, 13.674150248989463));
        $polygon->addPoint(new Coordinate(52.200047867372632, 13.674412602558732));
        $polygon->addPoint(new Coordinate(52.203508755192161, 13.676183195784688));
        $polygon->addPoint(new Coordinate(52.206863863393664, 13.678688379004598));
        $polygon->addPoint(new Coordinate(52.213457236066461, 13.67043505422771));
        $polygon->addPoint(new Coordinate(52.217430174350739, 13.66775787435472));
        $polygon->addPoint(new Coordinate(52.221683654934168, 13.661622740328312));

        $outsidePolygon = new Polygon();
        $outsidePolygon->addPoint(new Coordinate(52.2123983502388, 13.677485324442387));
        $outsidePolygon->addPoint(new Coordinate(52.215186841785908, 13.683912232518196));
        $outsidePolygon->addPoint(new Coordinate(52.207024795934558, 13.685344364494085));

        $this->assertFalse($polygon->containsGeometry($outsidePolygon));
    }

    public function testIfPolygonContainsGeometryWithPolylineInsideWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.221651719883084, 13.661613101139665));
        $polygon->addPoint(new Coordinate(52.215716242790222, 13.662988655269146));
        $polygon->addPoint(new Coordinate(52.211922844871879, 13.662990247830749));
        $polygon->addPoint(new Coordinate(52.208002796396613, 13.664533020928502));
        $polygon->addPoint(new Coordinate(52.203469779342413, 13.664621533825994));
        $polygon->addPoint(new Coordinate(52.199896154925227, 13.665583860129118));
        $polygon->addPoint(new Coordinate(52.199177406728268, 13.665664242580533));
        $polygon->addPoint(new Coordinate(52.197426510974765, 13.664221465587616));
        $polygon->addPoint(new Coordinate(52.196468207985163, 13.674150248989463));
        $polygon->addPoint(new Coordinate(52.200047867372632, 13.674412602558732));
        $polygon->addPoint(new Coordinate(52.203508755192161, 13.676183195784688));
        $polygon->addPoint(new Coordinate(52.206863863393664, 13.678688379004598));
        $polygon->addPoint(new Coordinate(52.213457236066461, 13.67043505422771));
        $polygon->addPoint(new Coordinate(52.217430174350739, 13.66775787435472));
        $polygon->addPoint(new Coordinate(52.221683654934168, 13.661622740328312));

        $insidePolyline = new Polyline();
        $insidePolyline->addPoint(new Coordinate(52.206110581755638, 13.674710914492607));
        $insidePolyline->addPoint(new Coordinate(52.202216433361173, 13.673997698351741));
        $insidePolyline->addPoint(new Coordinate(52.20279042609036, 13.666518358513713));
        $insidePolyline->addPoint(new Coordinate(52.209159163758159, 13.667042898014188));
        $insidePolyline->addPoint(new Coordinate(52.215381134301424, 13.664670567959547));
        $insidePolyline->addPoint(new Coordinate(52.209875900298357, 13.672981224954128));

        $this->assertTrue($polygon->containsGeometry($insidePolyline));
    }

    public function testIfPolygonContainsGeometryWithPolylineInsideAndOutsideWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.221651719883084, 13.661613101139665));
        $polygon->addPoint(new Coordinate(52.215716242790222, 13.662988655269146));
        $polygon->addPoint(new Coordinate(52.211922844871879, 13.662990247830749));
        $polygon->addPoint(new Coordinate(52.208002796396613, 13.664533020928502));
        $polygon->addPoint(new Coordinate(52.203469779342413, 13.664621533825994));
        $polygon->addPoint(new Coordinate(52.199896154925227, 13.665583860129118));
        $polygon->addPoint(new Coordinate(52.199177406728268, 13.665664242580533));
        $polygon->addPoint(new Coordinate(52.197426510974765, 13.664221465587616));
        $polygon->addPoint(new Coordinate(52.196468207985163, 13.674150248989463));
        $polygon->addPoint(new Coordinate(52.200047867372632, 13.674412602558732));
        $polygon->addPoint(new Coordinate(52.203508755192161, 13.676183195784688));
        $polygon->addPoint(new Coordinate(52.206863863393664, 13.678688379004598));
        $polygon->addPoint(new Coordinate(52.213457236066461, 13.67043505422771));
        $polygon->addPoint(new Coordinate(52.217430174350739, 13.66775787435472));
        $polygon->addPoint(new Coordinate(52.221683654934168, 13.661622740328312));

        $inAndOutSidePolyline = new Polyline();
        $inAndOutSidePolyline->addPoint(new Coordinate(52.206110581755638, 13.674710914492607));
        $inAndOutSidePolyline->addPoint(new Coordinate(52.202216433361173, 13.673997698351741));
        $inAndOutSidePolyline->addPoint(new Coordinate(52.20279042609036, 13.666518358513713));
        $inAndOutSidePolyline->addPoint(new Coordinate(52.209159163758159, 13.667042898014188));
        $inAndOutSidePolyline->addPoint(new Coordinate(52.215381134301424, 13.664670567959547));
        $inAndOutSidePolyline->addPoint(new Coordinate(52.209875900298357, 13.672981224954128));
        $inAndOutSidePolyline->addPoint(new Coordinate(52.211303086951375, 13.676270367577672));
        $inAndOutSidePolyline->addPoint(new Coordinate(52.20556978136301, 13.688599476590753));
        $inAndOutSidePolyline->addPoint(new Coordinate(52.205583276227117, 13.688599476590753));
        $inAndOutSidePolyline->addPoint(new Coordinate(52.204232113435864, 13.683774350211024));

        $this->assertFalse($polygon->containsGeometry($inAndOutSidePolyline));
    }

    public function testIfPolygonContainsGeometryWithPolylineOutsideWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.221651719883084, 13.661613101139665));
        $polygon->addPoint(new Coordinate(52.215716242790222, 13.662988655269146));
        $polygon->addPoint(new Coordinate(52.211922844871879, 13.662990247830749));
        $polygon->addPoint(new Coordinate(52.208002796396613, 13.664533020928502));
        $polygon->addPoint(new Coordinate(52.203469779342413, 13.664621533825994));
        $polygon->addPoint(new Coordinate(52.199896154925227, 13.665583860129118));
        $polygon->addPoint(new Coordinate(52.199177406728268, 13.665664242580533));
        $polygon->addPoint(new Coordinate(52.197426510974765, 13.664221465587616));
        $polygon->addPoint(new Coordinate(52.196468207985163, 13.674150248989463));
        $polygon->addPoint(new Coordinate(52.200047867372632, 13.674412602558732));
        $polygon->addPoint(new Coordinate(52.203508755192161, 13.676183195784688));
        $polygon->addPoint(new Coordinate(52.206863863393664, 13.678688379004598));
        $polygon->addPoint(new Coordinate(52.213457236066461, 13.67043505422771));
        $polygon->addPoint(new Coordinate(52.217430174350739, 13.66775787435472));
        $polygon->addPoint(new Coordinate(52.221683654934168, 13.661622740328312));

        $outsidePolyline = new Polyline();
        $outsidePolyline->addPoint(new Coordinate(52.2123983502388, 13.677485324442387));
        $outsidePolyline->addPoint(new Coordinate(52.215186841785908, 13.683912232518196));
        $outsidePolyline->addPoint(new Coordinate(52.207024795934558, 13.685344364494085));

        $this->assertFalse($polygon->containsGeometry($outsidePolyline));
    }

    public function testIfPolygonContainsGeometryWithLineInsideWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.221651719883084, 13.661613101139665));
        $polygon->addPoint(new Coordinate(52.215716242790222, 13.662988655269146));
        $polygon->addPoint(new Coordinate(52.211922844871879, 13.662990247830749));
        $polygon->addPoint(new Coordinate(52.208002796396613, 13.664533020928502));
        $polygon->addPoint(new Coordinate(52.203469779342413, 13.664621533825994));
        $polygon->addPoint(new Coordinate(52.199896154925227, 13.665583860129118));
        $polygon->addPoint(new Coordinate(52.199177406728268, 13.665664242580533));
        $polygon->addPoint(new Coordinate(52.197426510974765, 13.664221465587616));
        $polygon->addPoint(new Coordinate(52.196468207985163, 13.674150248989463));
        $polygon->addPoint(new Coordinate(52.200047867372632, 13.674412602558732));
        $polygon->addPoint(new Coordinate(52.203508755192161, 13.676183195784688));
        $polygon->addPoint(new Coordinate(52.206863863393664, 13.678688379004598));
        $polygon->addPoint(new Coordinate(52.213457236066461, 13.67043505422771));
        $polygon->addPoint(new Coordinate(52.217430174350739, 13.66775787435472));
        $polygon->addPoint(new Coordinate(52.221683654934168, 13.661622740328312));

        $insideLine = new Line(
            new Coordinate(52.206110581755638, 13.674710914492607),
            new Coordinate(52.202216433361173, 13.673997698351741)
        );

        $this->assertTrue($polygon->containsGeometry($insideLine));
    }

    public function testIfPolygonContainsGeometryWithLineInsideAndOutsideWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.221651719883084, 13.661613101139665));
        $polygon->addPoint(new Coordinate(52.215716242790222, 13.662988655269146));
        $polygon->addPoint(new Coordinate(52.211922844871879, 13.662990247830749));
        $polygon->addPoint(new Coordinate(52.208002796396613, 13.664533020928502));
        $polygon->addPoint(new Coordinate(52.203469779342413, 13.664621533825994));
        $polygon->addPoint(new Coordinate(52.199896154925227, 13.665583860129118));
        $polygon->addPoint(new Coordinate(52.199177406728268, 13.665664242580533));
        $polygon->addPoint(new Coordinate(52.197426510974765, 13.664221465587616));
        $polygon->addPoint(new Coordinate(52.196468207985163, 13.674150248989463));
        $polygon->addPoint(new Coordinate(52.200047867372632, 13.674412602558732));
        $polygon->addPoint(new Coordinate(52.203508755192161, 13.676183195784688));
        $polygon->addPoint(new Coordinate(52.206863863393664, 13.678688379004598));
        $polygon->addPoint(new Coordinate(52.213457236066461, 13.67043505422771));
        $polygon->addPoint(new Coordinate(52.217430174350739, 13.66775787435472));
        $polygon->addPoint(new Coordinate(52.221683654934168, 13.661622740328312));

        $inAndOutSidePolyline = new Line(
            new Coordinate(52.207389576360583, 13.670525830239058),
            new Coordinate(52.210680730640888, 13.687128368765116)
        );

        $this->assertFalse($polygon->containsGeometry($inAndOutSidePolyline));
    }

    public function testIfPolygonContainsGeometryWithLineOutsideWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.221651719883084, 13.661613101139665));
        $polygon->addPoint(new Coordinate(52.215716242790222, 13.662988655269146));
        $polygon->addPoint(new Coordinate(52.211922844871879, 13.662990247830749));
        $polygon->addPoint(new Coordinate(52.208002796396613, 13.664533020928502));
        $polygon->addPoint(new Coordinate(52.203469779342413, 13.664621533825994));
        $polygon->addPoint(new Coordinate(52.199896154925227, 13.665583860129118));
        $polygon->addPoint(new Coordinate(52.199177406728268, 13.665664242580533));
        $polygon->addPoint(new Coordinate(52.197426510974765, 13.664221465587616));
        $polygon->addPoint(new Coordinate(52.196468207985163, 13.674150248989463));
        $polygon->addPoint(new Coordinate(52.200047867372632, 13.674412602558732));
        $polygon->addPoint(new Coordinate(52.203508755192161, 13.676183195784688));
        $polygon->addPoint(new Coordinate(52.206863863393664, 13.678688379004598));
        $polygon->addPoint(new Coordinate(52.213457236066461, 13.67043505422771));
        $polygon->addPoint(new Coordinate(52.217430174350739, 13.66775787435472));
        $polygon->addPoint(new Coordinate(52.221683654934168, 13.661622740328312));

        $outsidePolyline = new Line(
            new Coordinate(52.215186841785908, 13.683912232518196),
            new Coordinate(52.207024795934558, 13.685344364494085)
        );

        $this->assertFalse($polygon->containsGeometry($outsidePolyline));
    }

    public function testIfPolygonContainsGeometryWithPointInsideWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.221651719883084, 13.661613101139665));
        $polygon->addPoint(new Coordinate(52.215716242790222, 13.662988655269146));
        $polygon->addPoint(new Coordinate(52.211922844871879, 13.662990247830749));
        $polygon->addPoint(new Coordinate(52.208002796396613, 13.664533020928502));
        $polygon->addPoint(new Coordinate(52.203469779342413, 13.664621533825994));
        $polygon->addPoint(new Coordinate(52.199896154925227, 13.665583860129118));
        $polygon->addPoint(new Coordinate(52.199177406728268, 13.665664242580533));
        $polygon->addPoint(new Coordinate(52.197426510974765, 13.664221465587616));
        $polygon->addPoint(new Coordinate(52.196468207985163, 13.674150248989463));
        $polygon->addPoint(new Coordinate(52.200047867372632, 13.674412602558732));
        $polygon->addPoint(new Coordinate(52.203508755192161, 13.676183195784688));
        $polygon->addPoint(new Coordinate(52.206863863393664, 13.678688379004598));
        $polygon->addPoint(new Coordinate(52.213457236066461, 13.67043505422771));
        $polygon->addPoint(new Coordinate(52.217430174350739, 13.66775787435472));
        $polygon->addPoint(new Coordinate(52.221683654934168, 13.661622740328312));

        $this->assertTrue($polygon->containsGeometry(new Coordinate(52.206110581755638, 13.674710914492607)));
    }

    public function testIfPolygonContainsGeometryWithPointOutsideWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.221651719883084, 13.661613101139665));
        $polygon->addPoint(new Coordinate(52.215716242790222, 13.662988655269146));
        $polygon->addPoint(new Coordinate(52.211922844871879, 13.662990247830749));
        $polygon->addPoint(new Coordinate(52.208002796396613, 13.664533020928502));
        $polygon->addPoint(new Coordinate(52.203469779342413, 13.664621533825994));
        $polygon->addPoint(new Coordinate(52.199896154925227, 13.665583860129118));
        $polygon->addPoint(new Coordinate(52.199177406728268, 13.665664242580533));
        $polygon->addPoint(new Coordinate(52.197426510974765, 13.664221465587616));
        $polygon->addPoint(new Coordinate(52.196468207985163, 13.674150248989463));
        $polygon->addPoint(new Coordinate(52.200047867372632, 13.674412602558732));
        $polygon->addPoint(new Coordinate(52.203508755192161, 13.676183195784688));
        $polygon->addPoint(new Coordinate(52.206863863393664, 13.678688379004598));
        $polygon->addPoint(new Coordinate(52.213457236066461, 13.67043505422771));
        $polygon->addPoint(new Coordinate(52.217430174350739, 13.66775787435472));
        $polygon->addPoint(new Coordinate(52.221683654934168, 13.661622740328312));

        $this->assertFalse($polygon->containsGeometry(new Coordinate(52.2123983502388, 13.677485324442387)));
    }

    public function testGetReverseWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.5, 13.5));
        $polygon->addPoint(new Coordinate(64.1, - 21.9));
        $polygon->addPoint(new Coordinate(40.7, - 74.0));
        $polygon->addPoint(new Coordinate(33.9, - 118.4));

        $reversed = $polygon->getReverse();

        $expected = new Polygon();
        $expected->addPoint(new Coordinate(33.9, - 118.4));
        $expected->addPoint(new Coordinate(40.7, - 74.0));
        $expected->addPoint(new Coordinate(64.1, - 21.9));
        $expected->addPoint(new Coordinate(52.5, 13.5));

        $this->assertEquals($expected, $reversed);
    }

    public function testReverseTwiceWorksAsExpected()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.5, 13.5));
        $polygon->addPoint(new Coordinate(64.1, - 21.9));
        $polygon->addPoint(new Coordinate(40.7, - 74.0));
        $polygon->addPoint(new Coordinate(33.9, - 118.4));

        $doubleReversed = $polygon->getReverse()->getReverse();

        $this->assertEquals($polygon, $doubleReversed);
    }
}
