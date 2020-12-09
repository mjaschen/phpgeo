<?php

declare(strict_types=1);

namespace Location;

use Location\Distance\Vincenty;
use Location\Exception\InvalidGeometryException;
use PHPUnit\Framework\TestCase;

class PolylineTest extends TestCase
{
    /**
     * @var \Location\Polyline
     */
    protected $polyline;

    public function setUp(): void
    {
        $this->polyline = new Polyline();
        $this->polyline->addPoint(new Coordinate(52.5, 13.5));
        $this->polyline->addPoint(new Coordinate(64.1, -21.9));
        $this->polyline->addPoint(new Coordinate(40.7, -74.0));
        $this->polyline->addPoint(new Coordinate(33.9, -118.4));
    }

    public function testCreatePolyline(): void
    {
        static::assertCount(4, $this->polyline->getPoints());
    }

    public function testGetSegments(): void
    {
        $segments = $this->polyline->getSegments();

        static::assertEquals(new Line(new Coordinate(52.5, 13.5), new Coordinate(64.1, -21.9)), $segments[0]);
        static::assertEquals(new Line(new Coordinate(64.1, -21.9), new Coordinate(40.7, -74.0)), $segments[1]);
        static::assertEquals(new Line(new Coordinate(40.7, -74.0), new Coordinate(33.9, -118.4)), $segments[2]);
    }

    public function testGetSegmentsForOnlyOnePointInLineWorksAsExpected(): void
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(52.5, 13.5));

        static::assertEquals([], $polyline->getSegments());
    }

    public function testGetLength(): void
    {
        static::assertEqualsWithDelta(10576798.9, $this->polyline->getLength(new Vincenty()), 0.1, '');
    }

    public function testGetReverseWorksAsExpected(): void
    {
        $reversed = $this->polyline->getReverse();

        $expected = new Polyline();
        $expected->addPoint(new Coordinate(33.9, -118.4));
        $expected->addPoint(new Coordinate(40.7, -74.0));
        $expected->addPoint(new Coordinate(64.1, -21.9));
        $expected->addPoint(new Coordinate(52.5, 13.5));

        static::assertEquals($expected, $reversed);
    }

    public function testReverseTwiceWorksAsExpected(): void
    {
        $doubleReversed = $this->polyline->getReverse()->getReverse();

        static::assertEquals($this->polyline, $doubleReversed);
    }

    public function testGetBoundsWorksAsExpected(): void
    {
        $expected = new Bounds(new Coordinate(64.1, -118.4), new Coordinate(33.9, 13.5));

        static::assertEquals($expected, $this->polyline->getBounds());
    }

    public function testAddUniquePointWorksAsExpeted(): void
    {
        $expected = $this->polyline;
        $unique = new Polyline();

        // Pass 1
        $unique->addUniquePoint(new Coordinate(52.5, 13.5));
        $unique->addUniquePoint(new Coordinate(64.1, -21.9));
        $unique->addUniquePoint(new Coordinate(40.7, -74.0));
        $unique->addUniquePoint(new Coordinate(33.9, -118.4));

        // Pass 2
        $unique->addUniquePoint(new Coordinate(52.5, 13.5));
        $unique->addUniquePoint(new Coordinate(64.1, -21.9));
        $unique->addUniquePoint(new Coordinate(40.7, -74.0));
        $unique->addUniquePoint(new Coordinate(33.9, -118.4));

        static::assertEquals($unique, $expected);
    }

    public function testAddUniquePointWithAllowedDistanceZero(): void
    {
        $expected = $this->polyline;
        $actual = clone $expected;

        $actual->addUniquePoint(new Coordinate(33.9, -118.4), .0);

        static::assertEquals($expected, $actual);

        $expected->addPoint(new Coordinate(33.90001, -118.40001));
        $actual->addUniquePoint(new Coordinate(33.90001, -118.40001), .0);

        static::assertEquals($expected, $actual);
    }

    public function testAddUniquePointWithAllowedDistance(): void
    {
        $expected = $this->polyline;
        $actual = clone $expected;

        $actual->addUniquePoint(new Coordinate(33.90000001, -118.40000001), .001);

        static::assertEquals($expected, $actual);

        $expected = $this->polyline;
        $actual = clone $expected;

        $actual->addUniquePoint(new Coordinate(33.900001, -118.400001), 1);

        static::assertEquals($expected, $actual);
    }

    public function testGetAveragePointWorksAsExpected(): void
    {
        $middle = $this->polyline->getAveragePoint();

        $this->assertEquals($middle, new Coordinate(47.8, -50.2));
    }

    public function testGetAveragePointCrossingDateLine(): void
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(80.0, 179.0));
        $polyline->addPoint(new Coordinate(80.0, -179.0));

        static::markTestSkipped('Polyline crossing dateline');
    }

    public function testGetAveragePointWithNoPoints(): void
    {
        $polyline = new Polyline();

        $this->expectException(InvalidGeometryException::class);
        $this->expectExceptionMessage('Polyline doesn\'t contain points');
        $this->expectExceptionCode(9464188927);

        $middle = $polyline->getAveragePoint();
    }
}
