<?php

declare(strict_types=1);

namespace Location\Bearing;

use Location\Coordinate;
use PHPUnit\Framework\TestCase;

class BearingEllipsoidalTest extends TestCase
{
    public function testIfCalculateBearingNorthernWorksAsExpected(): void
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(10, 0);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(0.0, $bearingCalculator->calculateBearing($point1, $point2));
    }

    public function testIfCalculateBearingSouthernWorksAsExpected(): void
    {
        $point1 = new Coordinate(10, 0);
        $point2 = new Coordinate(0, 0);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(180.0, $bearingCalculator->calculateBearing($point1, $point2));
    }

    public function testIfCalculateBearingEasternWorksAsExpected(): void
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, 10);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(90.0, $bearingCalculator->calculateBearing($point1, $point2));
    }

    public function testIfCalculateBearingWesternWorksAsExpected(): void
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, - 10);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(270.0, $bearingCalculator->calculateBearing($point1, $point2));
    }

    public function testIfCalculateBearingNorthEasternWorksAsExpected(): void
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0.1, 0.1);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEqualsWithDelta(45.0, $bearingCalculator->calculateBearing($point1, $point2), 0.2, '');
    }

    public function testIfCalculateBearingNorthWesternWorksAsExpected(): void
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0.1, -0.1);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEqualsWithDelta(315.0, $bearingCalculator->calculateBearing($point1, $point2), 0.2, '');
    }

    public function testIfCalculateBearingSouthEasternWorksAsExpected(): void
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(- 0.1, 0.1);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEqualsWithDelta(135.0, $bearingCalculator->calculateBearing($point1, $point2), 0.2, '');
    }

    public function testIfCalculateBearingSouthWesternWorksAsExpected(): void
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(- 0.1, - 0.1);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEqualsWithDelta(225.0, $bearingCalculator->calculateBearing($point1, $point2), 0.2, '');
    }

    public function testIfCalculateFinalBearingNorthernWorksAsExpected(): void
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(10, 0);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(0.0, $bearingCalculator->calculateFinalBearing($point1, $point2));
    }

    public function testIfCalculateFinalBearingSouthernWorksAsExpected(): void
    {
        $point1 = new Coordinate(10, 0);
        $point2 = new Coordinate(0, 0);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(180.0, $bearingCalculator->calculateFinalBearing($point1, $point2));
    }

    public function testIfCalculateFinalBearingEasternWorksAsExpected(): void
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, 10);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(90.0, $bearingCalculator->calculateFinalBearing($point1, $point2));
    }

    public function testIfCalculateFinalBearingWesternWorksAsExpected(): void
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, - 10);

        $bearingCalculator = new BearingEllipsoidal();

        $this->assertEquals(270.0, $bearingCalculator->calculateFinalBearing($point1, $point2));
    }

    public function testIfCalculateDestinationEasternWorksAsExpected(): void
    {
        $bearingCalculator = new BearingSpherical();

        $point = new Coordinate(0, 0);
        $destination = $bearingCalculator->calculateDestination($point, 90, 111195.0837);

        // 1 degree in longitude at the equator:
        // 2πr/360 = 40030230.1407 meters/360 = 111195.0837 meters
        // so we expect a latitude of 0 degrees and a longitude
        // of 1 degree:

        $this->assertEqualsWithDelta(0.0, $destination->getLat(), 0.0001, '');
        $this->assertEqualsWithDelta(1.0, $destination->getLng(), 0.0001, '');
    }

    public function testIfCalculateDestinationWesternWorksAsExpected(): void
    {
        $bearingCalculator = new BearingSpherical();

        $point = new Coordinate(0, 0);
        $destination = $bearingCalculator->calculateDestination($point, 270, 111195.0837);

        // 1 degree in longitude at the equator:
        // 2πr/360 = 40030230.1407 meters/360 = 111195.0837 meters

        $this->assertEqualsWithDelta(0.0, $destination->getLat(), 0.0001, '');
        $this->assertEqualsWithDelta(-1.0, $destination->getLng(), 0.0001, '');
    }

    public function testIfCalculateDestinationNorthernWorksAsExpected(): void
    {
        $bearingCalculator = new BearingSpherical();

        $point = new Coordinate(0, 0);
        $destination = $bearingCalculator->calculateDestination($point, 0, 111195.0837);

        // 1 degree in longitude at the equator:
        // 2πr/360 = 40030230.1407 meters/360 = 111195.0837 meters

        $this->assertEqualsWithDelta(1.0, $destination->getLat(), 0.0001, '');
        $this->assertEqualsWithDelta(0.0, $destination->getLng(), 0.0001, '');
    }

    public function testIfCalculateDestinationNorthern360WorksAsExpected(): void
    {
        $bearingCalculator = new BearingSpherical();

        $point = new Coordinate(0, 0);
        $destination = $bearingCalculator->calculateDestination($point, 360, 111195.0837);

        // 1 degree in longitude at the equator:
        // 2πr/360 = 40030230.1407 meters/360 = 111195.0837 meters

        $this->assertEqualsWithDelta(1.0, $destination->getLat(), 0.0001, '');
        $this->assertEqualsWithDelta(0.0, $destination->getLng(), 0.0001, '');
    }

    public function testIfCalculateDestinationSouthernWorksAsExpected(): void
    {
        $bearingCalculator = new BearingSpherical();

        $point = new Coordinate(0, 0);
        $destination = $bearingCalculator->calculateDestination($point, 180, 111195.0837);

        // 1 degree in longitude at the equator:
        // 2πr/360 = 40030230.1407 meters/360 = 111195.0837 meters

        $this->assertEqualsWithDelta(-1.0, $destination->getLat(), 0.0001, '');
        $this->assertEqualsWithDelta(0.0, $destination->getLng(), 0.0001, '');
    }

    public function testIfBearingForTheSamePointIsZero(): void
    {
        $bearingCalculator = new BearingEllipsoidal();
        $point1 = new Coordinate(50.12345, 10.23456);
        $point2 = new Coordinate(50.12345, 10.23456);

        $this->assertEquals(0.0, $bearingCalculator->calculateBearing($point1, $point2));
    }
}
