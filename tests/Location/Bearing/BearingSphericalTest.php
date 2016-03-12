<?php

namespace Location\Bearing;

use Location\Coordinate;

class BearingSphericalTest extends \PHPUnit_Framework_TestCase
{
    public function testIfCalculateBearingNorthernWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(10, 0);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(0.0, $bearingCalculator->calculateBearing($point1, $point2));
    }

    public function testIfCalculateBearingSouthernWorksAsExpected()
    {
        $point1 = new Coordinate(10, 0);
        $point2 = new Coordinate(0, 0);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(180.0, $bearingCalculator->calculateBearing($point1, $point2));
    }

    public function testIfCalculateBearingEasternWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, 10);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(90.0, $bearingCalculator->calculateBearing($point1, $point2));
    }

    public function testIfCalculateBearingWesternWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, - 10);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(270.0, $bearingCalculator->calculateBearing($point1, $point2));
    }

    public function testIfCalculateBearingNorthEasternWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0.1, 0.1);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(45.0, $bearingCalculator->calculateBearing($point1, $point2), '', 0.1);
    }

    public function testIfCalculateBearingNorthWesternWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0.1, - 0.1);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(315.0, $bearingCalculator->calculateBearing($point1, $point2), '', 0.1);
    }

    public function testIfCalculateBearingSouthEasternWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(- 0.1, 0.1);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(135.0, $bearingCalculator->calculateBearing($point1, $point2), '', 0.1);
    }

    public function testIfCalculateBearingSouthWesternWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(- 0.1, - 0.1);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(225.0, $bearingCalculator->calculateBearing($point1, $point2), '', 0.1);
    }

    public function testIfCalculateFinalBearingNorthernWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(10, 0);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(0.0, $bearingCalculator->calculateFinalBearing($point1, $point2));
    }

    public function testIfCalculateFinalBearingSouthernWorksAsExpected()
    {
        $point1 = new Coordinate(10, 0);
        $point2 = new Coordinate(0, 0);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(180.0, $bearingCalculator->calculateFinalBearing($point1, $point2));
    }

    public function testIfCalculateFinalBearingEasternWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, 10);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(90.0, $bearingCalculator->calculateFinalBearing($point1, $point2));
    }

    public function testIfCalculateFinalBearingWesternWorksAsExpected()
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, - 10);

        $bearingCalculator = new BearingSpherical();

        $this->assertEquals(270.0, $bearingCalculator->calculateFinalBearing($point1, $point2));
    }

    public function testIfCalculateDestinationEasternWorksAsExpected()
    {
        $bearingCalculator = new BearingSpherical();

        $point = new Coordinate(0, 0);
        $destination = $bearingCalculator->calculateDestination($point, 90, 111195.0837);

        // 1 degree in longitude at the equator:
        // 2πr/360 = 40030230.1407 meters/360 = 111195.0837 meters
        // so we expect a latitude of 0 degrees and a longitude
        // of 1 degree:

        $this->assertEquals(0.0, $destination->getLat(), '', 0.0001);
        $this->assertEquals(1.0, $destination->getLng(), '', 0.0001);
    }

    public function testIfCalculateDestinationWesternWorksAsExpected()
    {
        $bearingCalculator = new BearingSpherical();

        $point = new Coordinate(0, 0);
        $destination = $bearingCalculator->calculateDestination($point, 270, 111195.0837);

        // 1 degree in longitude at the equator:
        // 2πr/360 = 40030230.1407 meters/360 = 111195.0837 meters

        $this->assertEquals(0.0, $destination->getLat(), '', 0.0001);
        $this->assertEquals(-1.0, $destination->getLng(), '', 0.0001);
    }

    public function testIfCalculateDestinationNorthernWorksAsExpected()
    {
        $bearingCalculator = new BearingSpherical();

        $point = new Coordinate(0, 0);
        $destination = $bearingCalculator->calculateDestination($point, 0, 111195.0837);

        // 1 degree in longitude at the equator:
        // 2πr/360 = 40030230.1407 meters/360 = 111195.0837 meters

        $this->assertEquals(1.0, $destination->getLat(), '', 0.0001);
        $this->assertEquals(0.0, $destination->getLng(), '', 0.0001);
    }

    public function testIfCalculateDestinationNorthern360WorksAsExpected()
    {
        $bearingCalculator = new BearingSpherical();

        $point = new Coordinate(0, 0);
        $destination = $bearingCalculator->calculateDestination($point, 360, 111195.0837);

        // 1 degree in longitude at the equator:
        // 2πr/360 = 40030230.1407 meters/360 = 111195.0837 meters

        $this->assertEquals(1.0, $destination->getLat(), '', 0.0001);
        $this->assertEquals(0.0, $destination->getLng(), '', 0.0001);
    }

    public function testIfCalculateDestinationSouthernWorksAsExpected()
    {
        $bearingCalculator = new BearingSpherical();

        $point = new Coordinate(0, 0);
        $destination = $bearingCalculator->calculateDestination($point, 180, 111195.0837);

        // 1 degree in longitude at the equator:
        // 2πr/360 = 40030230.1407 meters/360 = 111195.0837 meters

        $this->assertEquals(-1.0, $destination->getLat(), '', 0.0001);
        $this->assertEquals(0.0, $destination->getLng(), '', 0.0001);
    }
}
