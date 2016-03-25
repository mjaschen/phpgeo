<?php

namespace Location;

use Location\Processor\Polyline\SimplifyBearing;

class SimplifyBearingTest extends \PHPUnit_Framework_TestCase
{
    public function testSimplifyThreePointsToTwoPoints()
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(10.0, 10.0));
        $polyline->addPoint(new Coordinate(20.0, 20.0));
        $polyline->addPoint(new Coordinate(30.0, 10.0));

        $processor = new SimplifyBearing(85);

        // actual bearing difference between the both segments is
        // 83.3 degrees, therefore the middle point gets removed
        $simplified = $processor->simplify($polyline);

        $segments = $simplified->getSegments();

        $this->assertEquals(1, count($segments));
        $this->assertEquals(new Line(new Coordinate(10.0, 10.0), new Coordinate(30.0, 10.0)), $segments[0]);
    }

    public function testSimplifyTwoPointsImpossible()
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(10.0, 10.0));
        $polyline->addPoint(new Coordinate(20.0, 20.0));

        $processor = new SimplifyBearing(10);

        $simplified = $processor->simplify($polyline);

        $this->assertEquals($polyline, $simplified);
    }
}
