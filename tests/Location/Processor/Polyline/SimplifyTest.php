<?php

namespace Location;

use Location\Processor\Polyline\Simplify;

class SimplifyTest extends \PHPUnit_Framework_TestCase
{
    public function testSimplifyThreePointsToTwoPoints()
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(10.0, 10.0));
        $polyline->addPoint(new Coordinate(20.0, 20.0));
        $polyline->addPoint(new Coordinate(30.0, 10.0));

        $processor = new Simplify($polyline);

        // actual deviation is 1046 km, so 1500 km is enough of tolerance to strip the 2nd coordinate
        $simplified = $processor->simplify(1500000);

        $segments = $simplified->getSegments();

        $this->assertEquals(1, count($segments));
        $this->assertEquals(new Line(new Coordinate(10.0, 10.0), new Coordinate(30.0, 10.0)), $segments[0]);
    }

    public function testSimplifyThreePointsImpossible()
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(10.0, 10.0));
        $polyline->addPoint(new Coordinate(20.0, 20.0));
        $polyline->addPoint(new Coordinate(30.0, 10.0));

        $processor = new Simplify($polyline);

        $simplified = $processor->simplify(1000);

        $this->assertEquals($polyline, $simplified);
    }
}
