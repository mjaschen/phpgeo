<?php

declare(strict_types=1);

namespace Location;

use Location\Processor\Polyline\SimplifyDouglasPeucker;
use PHPUnit\Framework\TestCase;

class SimplifyDouglasPeuckerTest extends TestCase
{
    public function testSimplifyThreePointsToTwoPoints()
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(10.0, 10.0));
        $polyline->addPoint(new Coordinate(20.0, 20.0));
        $polyline->addPoint(new Coordinate(30.0, 10.0));

        $processor = new SimplifyDouglasPeucker(1500000);

        // actual deviation is 1046 km, so 1500 km is enough of tolerance to strip the 2nd coordinate
        $simplified = $processor->simplify($polyline);

        $segments = $simplified->getSegments();

        $this->assertCount(1, $segments);
        $this->assertEquals(new Line(new Coordinate(10.0, 10.0), new Coordinate(30.0, 10.0)), $segments[0]);
    }

    public function testSimplifyFourPointsToTwoPoints()
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(50.0, 10.0));
        $polyline->addPoint(new Coordinate(40.0, 20.0));
        $polyline->addPoint(new Coordinate(30.0, 10.0));
        $polyline->addPoint(new Coordinate(20.0, 30.0));

        $processor = new SimplifyDouglasPeucker(1500000);

        $simplified = $processor->simplify($polyline);

        $segments = $simplified->getSegments();

        $this->assertCount(1, $segments);
        $this->assertEquals(new Line(new Coordinate(50.0, 10.0), new Coordinate(20.0, 30.0)), $segments[0]);
    }

    public function testSimplifyFourPointsToThreePoints()
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(50.0, 10.0));
        $polyline->addPoint(new Coordinate(40.0, 20.0));
        $polyline->addPoint(new Coordinate(30.0, 10.0));
        $polyline->addPoint(new Coordinate(20.0, 30.0));

        $processor = new SimplifyDouglasPeucker(1200000);

        $simplified = $processor->simplify($polyline);

        $segments = $simplified->getSegments();

        $this->assertCount(2, $segments);
        $this->assertEquals(new Line(new Coordinate(50.0, 10.0), new Coordinate(30.0, 10.0)), $segments[0]);
        $this->assertEquals(new Line(new Coordinate(30.0, 10.0), new Coordinate(20.0, 30.0)), $segments[1]);
    }

    public function testSimplifyThreePointsImpossible()
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(10.0, 10.0));
        $polyline->addPoint(new Coordinate(20.0, 20.0));
        $polyline->addPoint(new Coordinate(30.0, 10.0));

        $processor = new SimplifyDouglasPeucker(1000);

        $simplified = $processor->simplify($polyline);

        $this->assertEquals($polyline, $simplified);
    }
}
