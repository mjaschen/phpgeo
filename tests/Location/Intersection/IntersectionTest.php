<?php

declare(strict_types=1);

namespace Location\Intersection;

use Location\Coordinate;
use Location\Line;
use Location\Polygon;
use Location\Polyline;
use PHPUnit\Framework\TestCase;

class IntersectionTest extends TestCase
{
    protected $polygon;

    protected function setUp(): void
    {
        $coordinates = [
            [52.56571, 9.998658],
            [52.369576, 9.560167],
            [52.102252, 9.62397],
            [51.983342, 10.132727],
            [52.083498, 10.699142],
            [52.457087, 10.590607],
            [52.56571, 9.998658],
        ];

        $this->polygon = new Polygon();
        foreach ($coordinates as $coordinate) {
            $this->polygon->addPoint(new Coordinate($coordinate[0], $coordinate[1]));
        }
    }

    public function testLineIntersections(): void
    {
        // Lines
        $lineCenterCrossing = new Line(
            new Coordinate(52.237594, 9.287635),
            new Coordinate(52.258154, 11.010313)
        );
        $lineTop = new Line(
            new Coordinate(52.62456, 9.455537),
            new Coordinate(52.608249, 10.734953)
        );
        $lineBottom = new Line(
            new Coordinate(51.880405, 9.613366),
            new Coordinate(51.907345, 10.724879)
        );
        $lineRight = new Line(
            new Coordinate(52.720262, 10.627496),
            new Coordinate(51.859671, 10.812188)
        );

        $intersection = new Intersection();

        // By bounds
        $this->assertTrue(
            $intersection->intersects($lineCenterCrossing, $this->polygon, false)
        );
        $this->assertFalse($intersection->intersects($lineTop, $this->polygon, false));
        $this->assertFalse($intersection->intersects($lineBottom, $this->polygon, false));
        $this->assertTrue($intersection->intersects($lineRight, $this->polygon, false));

        // By shape
        $this->assertTrue(
            $intersection->intersects($lineCenterCrossing, $this->polygon, true)
        );
        $this->assertFalse($intersection->intersects($lineTop, $this->polygon, true));
        $this->assertFalse($intersection->intersects($lineBottom, $this->polygon, true));
        $this->assertFalse($intersection->intersects($lineRight, $this->polygon, true));
    }

    public function testCoordinateIntersections(): void
    {
        $intersection = new Intersection();

        // Coordinates
        $pointContained = new Coordinate(52.328745, 10.151638);
        $pointOutside = new Coordinate(52.549057, 10.475242);
        $pointOutsideLine = new Coordinate(52.252717, 10.728334);

        // By bounds
        $this->assertTrue($intersection->intersects($pointContained, $this->polygon, false));
        $this->assertFalse($intersection->intersects($pointOutside, $this->polygon, false));
        $this->assertFalse(
            $intersection->intersects($pointOutsideLine, $this->polygon, false)
        );

        // By shape
        $this->assertTrue($intersection->intersects($pointContained, $this->polygon, true));
        $this->assertFalse($intersection->intersects($pointOutside, $this->polygon, true));
        $this->assertFalse($intersection->intersects($pointOutsideLine, $this->polygon, true));
    }

    public function testPolygonIntersections(): void
    {
        $intersection = new Intersection();

        // Polygons
        $polygonLeftIntersecting = new Polygon();
        $coordinates = [
            [51.990136, 9.438747],
            [52.493904, 9.408525],
            [52.518432, 9.77791],
            [51.807794, 9.871935],
            [51.809766, 9.886408],
            [51.990136, 9.438747],
        ];
        foreach ($coordinates as $coordinate) {
            $polygonLeftIntersecting->addPoint(
                new Coordinate($coordinate[0], $coordinate[1])
            );
        }

        $polygonRightOutside = new Polygon();
        $coordinates = [
            [52.533043, 10.747941],
            [52.326314, 10.787294],
            [52.317063, 11.117259],
            [52.317063, 11.117259],
            [52.533043, 10.747941],
        ];
        foreach ($coordinates as $coordinate) {
            $polygonRightOutside->addPoint(
                new Coordinate($coordinate[0], $coordinate[1])
            );
        }

        // By bounds
        $this->assertTrue(
            $intersection->intersects($polygonLeftIntersecting, $this->polygon, false)
        );
        $this->assertFalse(
            $intersection->intersects($polygonRightOutside, $this->polygon, false)
        );

        // By shape
        $this->assertTrue(
            $intersection->intersects($polygonLeftIntersecting, $this->polygon, true)
        );
        $this->assertFalse(
            $intersection->intersects($polygonRightOutside, $this->polygon, true)
        );
    }

    public function testPolylineIntersections(): void
    {
        $intersection = new Intersection();

        $polyline1 = new Polyline();
        $polyline1->addPoint(new Coordinate(-4, -2));
        $polyline1->addPoint(new Coordinate(5, 2));
        $polyline1->addPoint(new Coordinate(-1, 7));
        $polyline1->addPoint(new Coordinate(-3, 4));

        $polyline2 = new Polyline();
        $polyline2->addPoint(new Coordinate(-8, 3));
        $polyline2->addPoint(new Coordinate(-5, -5));
        $polyline2->addPoint(new Coordinate(4, -3));

        $polyline4 = new Polyline();
        $polyline4->addPoint(new Coordinate(1, 10));
        $polyline4->addPoint(new Coordinate(-1, 5));
        $polyline4->addPoint(new Coordinate(-6, 9));

        $polyline3 = new Polyline();
        $polyline3->addPoint(new Coordinate(11, 13));
        $polyline3->addPoint(new Coordinate(21, 14));
        $polyline3->addPoint(new Coordinate(15, 18));

        $polyline5 = new Polyline();
        $polyline5->addPoint(new Coordinate(9, 22));
        $polyline5->addPoint(new Coordinate(13, 24));
        $polyline5->addPoint(new Coordinate(14, 20));
        $polyline5->addPoint(new Coordinate(8, 15));

        // By bounds
        $this->assertTrue($intersection->intersects($polyline3, $polyline5, false));
        $this->assertTrue($intersection->intersects($polyline5, $polyline3, false));

        $this->assertFalse($intersection->intersects($polyline2, $polyline3, false));
        $this->assertFalse($intersection->intersects($polyline3, $polyline2, false));

        $this->assertTrue($intersection->intersects($polyline1, $polyline2, false));
        $this->assertTrue($intersection->intersects($polyline2, $polyline1, false));

        $this->assertTrue($intersection->intersects($polyline1, $polyline4, false));
        $this->assertTrue($intersection->intersects($polyline4, $polyline1, false));

        // By shape
        $this->assertTrue($intersection->intersects($polyline1, $polyline4, true));
        $this->assertTrue($intersection->intersects($polyline4, $polyline1, true));

        $this->assertFalse($intersection->intersects($polyline1, $polyline3, true));
        $this->assertFalse($intersection->intersects($polyline3, $polyline1, true));

        $this->assertFalse($intersection->intersects($polyline1, $polyline5, true));
        $this->assertFalse($intersection->intersects($polyline5, $polyline1, true));

        $this->assertFalse($intersection->intersects($polyline2, $polyline3, true));
        $this->assertFalse($intersection->intersects($polyline3, $polyline2, true));

        $this->assertFalse($intersection->intersects($polyline2, $polyline4, true));
        $this->assertFalse($intersection->intersects($polyline4, $polyline2, true));

        $this->assertFalse($intersection->intersects($polyline2, $polyline5, true));
        $this->assertFalse($intersection->intersects($polyline5, $polyline2, true));
    }
}
