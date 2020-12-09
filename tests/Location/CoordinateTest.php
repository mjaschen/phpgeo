<?php

declare(strict_types=1);

namespace Location;

use InvalidArgumentException;
use Location\Distance\Vincenty;
use Location\Formatter\Coordinate\DecimalDegrees;
use PHPUnit\Framework\TestCase;

class CoordinateTest extends TestCase
{
    /**
     * @var Ellipsoid
     */
    protected $ellipsoid;

    /**
     * @var Coordinate
     */
    protected $coordinate;

    protected function setUp(): void
    {
        $ellipsoidConfig = [
            'name' => 'WGS-84',
            'a' => 6378137.0,
            'f' => 298.257223563,
        ];

        $this->ellipsoid = Ellipsoid::createFromArray($ellipsoidConfig);

        $this->coordinate = new Coordinate(52.5, 13.5, $this->ellipsoid);
    }

    public function testConstructorInvalidLatitudeOutOfBoundsWorksAsExpected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Latitude value must be numeric -90.0 .. +90.0 (given: 91)');

        $c = new Coordinate(91.0, 13.5, $this->ellipsoid);
    }

    public function testConstructorInvalidLongitudeOutOfBoundsWorksAsExpected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Longitude value must be numeric -180.0 .. +180.0 (given: 190)');

        $c = new Coordinate(52.2, 190.0, $this->ellipsoid);
    }

    public function testConstructorBoundChecksWorkAsExpected(): void
    {
        $c = new Coordinate(90.0, 180.0, $this->ellipsoid);

        $this->assertEquals(90.0, $c->getLat());
        $this->assertEquals(180.0, $c->getLng());

        $c = new Coordinate(-90.0, -180.0, $this->ellipsoid);

        $this->assertEquals(-90.0, $c->getLat());
        $this->assertEquals(-180.0, $c->getLng());

        $c = new Coordinate(-90, 180, $this->ellipsoid);

        $this->assertEquals(-90.0, $c->getLat());
        $this->assertEquals(180.0, $c->getLng());

        $c = new Coordinate(90, -180, $this->ellipsoid);

        $this->assertEquals(90.0, $c->getLat());
        $this->assertEquals(-180.0, $c->getLng());
    }

    public function testConstructorDefaultEllipsoid(): void
    {
        $c = new Coordinate(52.5, 13.5);

        $this->assertInstanceOf(Ellipsoid::class, $c->getEllipsoid());
    }

    public function testGetLat(): void
    {
        $this->assertEquals(52.5, $this->coordinate->getLat());
    }

    public function testGetLng(): void
    {
        $this->assertEquals(13.5, $this->coordinate->getLng());
    }

    public function testGetEllipsoid(): void
    {
        $this->assertEquals($this->ellipsoid, $this->coordinate->getEllipsoid());
    }

    public function testGetdistance(): void
    {
        $coordinate1 = new Coordinate(19.820664, -155.468066, $this->ellipsoid);
        $coordinate2 = new Coordinate(20.709722, -156.253333, $this->ellipsoid);

        $this->assertEquals(128130.850, $coordinate1->getDistance($coordinate2, new Vincenty()));
    }

    public function testFormat(): void
    {
        $this->assertEquals('52.50000 13.50000', $this->coordinate->format(new DecimalDegrees()));
    }

    public function testHasSameLocation(): void
    {
        $point1 = new Coordinate(0.0, 0.0);
        $point2 = new Coordinate(0.0, 0.0);

        $this->assertTrue($point1->hasSameLocation($point1, 0.0));
        $this->assertTrue($point1->hasSameLocation($point1, 0.1));

        $this->assertTrue($point1->hasSameLocation($point2, 0.0));
        $this->assertTrue($point1->hasSameLocation($point2, 0.1));

        $this->assertTrue($point2->hasSameLocation($point1, 0.0));
        $this->assertTrue($point2->hasSameLocation($point1, 0.1));

        // distance: 1 arc second
        $point2 = new Coordinate(0, 0.0002777778);

        $this->assertFalse($point1->hasSameLocation($point2, 0.0));

        // a longitude difference of 1 arc second is about ~30.9 meters on the equator line
        $this->assertFalse($point1->hasSameLocation($point2, 30.85));
        $this->assertTrue($point1->hasSameLocation($point2, 30.95));
    }
}
