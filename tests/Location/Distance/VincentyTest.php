<?php

namespace Location\Distance;

use Location\Distance\Vincenty;
use Location\Ellipsoid;
use Location\Coordinate;

class VincentyTest extends \PHPUnit_Framework_TestCase
{
    protected $ellipsoid;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $ellipsoidConfig = [
            'name' => 'WGS-84',
            'a'    => 6378137.0,
            'f'    => 298.257223563,
        ];

        $this->ellipsoid = Ellipsoid::createFromArray($ellipsoidConfig);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->ellipsoid);
    }

    /**
     * @covers Location\Distance\Vincenty::getDistance
     */
    public function testGetDistanceZero()
    {
        $coordinate1 = new Coordinate(52.5, 13.5, $this->ellipsoid);
        $coordinate2 = new Coordinate(52.5, 13.5, $this->ellipsoid);

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($coordinate1, $coordinate2);

        $this->assertEquals(0.0, $distance);
    }

    /**
     * @covers Location\Distance\Vincenty::getDistance
     */
    public function testGetDistanceSameLatitude()
    {
        $coordinate1 = new Coordinate(52.5, 13.5, $this->ellipsoid);
        $coordinate2 = new Coordinate(52.5, 13.1, $this->ellipsoid);

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($coordinate1, $coordinate2);

        $this->assertEquals(27164.059, $distance);
    }

    /**
     * @covers Location\Distance\Vincenty::getDistance
     */
    public function testGetDistanceSameLongitude()
    {
        $coordinate1 = new Coordinate(52.5, 13.5, $this->ellipsoid);
        $coordinate2 = new Coordinate(52.1, 13.5, $this->ellipsoid);

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($coordinate1, $coordinate2);

        $this->assertEquals(44509.218, $distance);
    }

    /**
     * @covers Location\Distance\Vincenty::getDistance
     */
    public function testGetDistance()
    {
        $coordinate1 = new Coordinate(19.820664, - 155.468066, $this->ellipsoid);
        $coordinate2 = new Coordinate(20.709722, - 156.253333, $this->ellipsoid);

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($coordinate1, $coordinate2);

        $this->assertEquals(128130.850, $distance);
    }

    /**
     * @covers Location\Distance\Vincenty::getDistance
     */
    public function testGetDistanceInternationalDateLine()
    {
        $coordinate1 = new Coordinate(20.0, 170.0, $this->ellipsoid);
        $coordinate2 = new Coordinate(- 20.0, - 170.0, $this->ellipsoid);

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($coordinate1, $coordinate2);

        $this->assertEquals(4932842.135, $distance);
    }

    /**
     * @covers Location\Distance\Vincenty::getDistance
     * @expectedException \Location\Exception\NotMatchingEllipsoidException
     */
    public function testNotMatchingEllispoids()
    {
        $coordinate1 = new Coordinate(19.820664, - 155.468066, $this->ellipsoid);
        $coordinate2 = new Coordinate(20.709722, - 156.253333, new Ellipsoid("AnotherEllipsoid", 6378140.0, 299.2));

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($coordinate1, $coordinate2);
    }
}
