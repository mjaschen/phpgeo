<?php

declare(strict_types=1);

namespace Location;

use Location\Processor\Polyline\SimplifyDouglasPeucker;
use PHPUnit\Framework\TestCase;

class SimplifyDouglasPeuckerTest extends TestCase
{
    public function testSimplifyThreePointsToTwoPoints(): void
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

    public function testSimplifyFourPointsToTwoPoints(): void
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

    public function testSimplifyFourPointsToThreePoints(): void
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

    public function testSimplifyThreePointsImpossible(): void
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(10.0, 10.0));
        $polyline->addPoint(new Coordinate(20.0, 20.0));
        $polyline->addPoint(new Coordinate(30.0, 10.0));

        $processor = new SimplifyDouglasPeucker(1000);

        $simplified = $processor->simplify($polyline);

        $this->assertEquals($polyline, $simplified);
    }

    public function testSimplifyPolygonFourPointsToThreePoints(): void
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(50.0, 10.0));
        $polygon->addPoint(new Coordinate(40.0, 20.0));
        $polygon->addPoint(new Coordinate(30.0, 10.0));
        $polygon->addPoint(new Coordinate(20.0, 30.0));

        $processor = new SimplifyDouglasPeucker(1200000);

        $simplified = $processor->simplifyGeometry($polygon);

        $segments = $simplified->getSegments();

        $this->assertCount(3, $segments);
        $this->assertEquals(new Line(new Coordinate(50.0, 10.0), new Coordinate(30.0, 10.0)), $segments[0]);
        $this->assertEquals(new Line(new Coordinate(30.0, 10.0), new Coordinate(20.0, 30.0)), $segments[1]);
        $this->assertEquals(new Line(new Coordinate(20.0, 30.0), new Coordinate(50.0, 10.0)), $segments[2]);
    }

    public function testSimplifyPolygon(): void
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(52.22756274954098, 13.642145602718902));
        $polygon->addPoint(new Coordinate(52.239006313247366, 13.707722618459625));
        $polygon->addPoint(new Coordinate(52.24786291062496, 13.690119804191333));
        $polygon->addPoint(new Coordinate(52.25589445256298, 13.6807244463633));
        $polygon->addPoint(new Coordinate(52.259384204167624, 13.670769072927543));
        $polygon->addPoint(new Coordinate(52.263977114630265, 13.664195445135501));
        $polygon->addPoint(new Coordinate(52.2677055, 13.6518132));
        $polygon->addPoint(new Coordinate(52.2732257, 13.6453916));
        $polygon->addPoint(new Coordinate(52.27315767127478, 13.632664578662904));

        $processor = new SimplifyDouglasPeucker(1000);

        $simplified = $processor->simplifyGeometry($polygon);

        $segments = $simplified->getSegments();

        $this->assertCount(3, $segments);
        $this->assertEquals(
            new Line(
                new Coordinate(52.22756274954098, 13.642145602718902),
                new Coordinate(52.239006313247366, 13.707722618459625)
            ),
            $segments[0]
        );
        $this->assertEquals(
            new Line(
                new Coordinate(52.239006313247366, 13.707722618459625),
                new Coordinate(52.27315767127478, 13.632664578662904)
            ),
            $segments[1]
        );
        $this->assertEquals(
            new Line(
                new Coordinate(52.27315767127478, 13.632664578662904),
                new Coordinate(52.22756274954098, 13.642145602718902)
            ),
            $segments[2]
        );
    }
}
