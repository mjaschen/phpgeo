<?php

use Location\Coordinate;
use Location\Factory\CoordinateFactory;

class CoordinateFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testIfFromStringForDecimalDegreesWorksAsExpected()
    {
        $this->assertEquals(new Coordinate(52, 13), CoordinateFactory::fromString("52, 13"));
        $this->assertEquals(new Coordinate(52, 13), CoordinateFactory::fromString("52 13"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("52.5, 13.5"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("52.5 13.5"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("52.5°, 13.5°"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("52.5° 13.5°"));
        $this->assertEquals(new Coordinate(-52.5, 13.5), CoordinateFactory::fromString("-52.5, 13.5"));
        $this->assertEquals(new Coordinate(-52.5, 13.5), CoordinateFactory::fromString("-52.5 13.5"));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString("-52.5, -13.5"));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString("-52.5 -13.5"));
        $this->assertEquals(new Coordinate(52.5, -13.5), CoordinateFactory::fromString("52.5, -13.5"));
        $this->assertEquals(new Coordinate(52.5, -13.5), CoordinateFactory::fromString("52.5 -13.5"));
    }

    public function testIfFromStringForDecimalDegreesWithCardinalLettersWorksAsExpected()
    {
        $this->assertEquals(new Coordinate(52, 13), CoordinateFactory::fromString("N52, E13"));
        $this->assertEquals(new Coordinate(52, 13), CoordinateFactory::fromString("N52 E13"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("N52.5, E13.5"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("N52.5 E13.5"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("N52.5°, E13.5°"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("N52.5° E13.5°"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("52.5N, 13.5E"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("52.5N 13.5E"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("52.5°N, 13.5°E"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("52.5°N 13.5°E"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("52.5° N, 13.5° E"));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString("52.5° N 13.5° E"));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString("S52.5, W13.5"));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString("S52.5 W13.5"));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString("52.5S, 13.5W"));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString("52.5S 13.5W"));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString("S 52.5, W 13.5"));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString("S 52.5 W 13.5"));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString("52.5 S, 13.5 W"));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString("52.5 S 13.5 W"));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIfInvalidFormatThrowsException()
    {
        CoordinateFactory::fromString("Lorem ipsum dolor sit amet");
    }
}
