<?php

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

class DecimalMinutesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DecimalMinutes
     */
    protected $formatter;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->formatter = new DecimalMinutes();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Location\Formatter\Coordinate\DMS::setUnits
     */
    public function testSetUnitsUTF8()
    {
        $this->formatter->setUnits(DMS::UNITS_UTF8);

        $this->assertAttributeSame(DMS::UNITS_UTF8, 'unitType', $this->formatter);
    }

    /**
     * @covers Location\Formatter\Coordinate\DMS::setUnits
     */
    public function testSetUnitsASCII()
    {
        $this->formatter->setUnits(DMS::UNITS_ASCII);

        $this->assertAttributeSame(DMS::UNITS_ASCII, 'unitType', $this->formatter);
    }

    /**
     * @covers Location\Formatter\Coordinate\DMS::setUnits
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid unit type
     */
    public function testSetUnitsInvalidType()
    {
        $this->formatter->setUnits('invalid');
    }

    /**
     * @covers Location\Formatter\Coordinate\DMS::format
     */
    public function testFormatDefaultSeparator()
    {
        $coordinate = new Coordinate(52.5, 13.5);

        $this->assertEquals("52° 30.000′ 013° 30.000′", $this->formatter->format($coordinate));
    }

    /**
     * @covers Location\Formatter\Coordinate\DMS::format
     */
    public function testFormatCustomSeparator()
    {
        $coordinate = new Coordinate(18.911306, - 155.678268);

        $this->formatter->setSeparator(", ");

        $this->assertEquals("18° 54.678′, -155° 40.696′", $this->formatter->format($coordinate));
    }

    /**
     * @covers Location\Formatter\Coordinate\DMS::format
     */
    public function testFormatCardinalLetters()
    {
        $coordinate = new Coordinate(18.911306, - 155.678268);

        $this->formatter->setSeparator(", ")->useCardinalLetters(true);

        $this->assertEquals("18° 54.678′ N, 155° 40.696′ W", $this->formatter->format($coordinate));
    }

    /**
     * @covers Location\Formatter\Coordinate\DMS::format
     */
    public function testFormatBothNegative()
    {
        $coordinate = new Coordinate(- 18.911306, - 155.678268);

        $this->formatter->setSeparator(", ");

        $this->assertEquals("-18° 54.678′, -155° 40.696′", $this->formatter->format($coordinate));
    }

    /**
     * @covers Location\Formatter\Coordinate\DMS::format
     */
    public function testFormatASCIIUnits()
    {
        $coordinate = new Coordinate(- 18.911306, - 155.678268);

        $this->formatter->setSeparator(", ")->setUnits(DMS::UNITS_ASCII);

        $this->assertEquals("-18° 54.678', -155° 40.696'", $this->formatter->format($coordinate));
    }

    /**
     * @covers Location\Formatter\Coordinate\DMS::format
     */
    public function testSetDigits()
    {
        $coordinate = new Coordinate(- 18.911306, - 155.678268);

        $this->formatter->setDigits(2);

        $this->assertEquals("-18° 54.68′ -155° 40.70′", $this->formatter->format($coordinate));
    }

    /**
     * @covers Location\Formatter\Coordinate\DMS::format
     */
    public function testSetDecimalPoint()
    {
        $coordinate = new Coordinate(- 18.911306, - 155.678268);

        $this->formatter->setDecimalPoint(',');

        $this->assertEquals("-18° 54,678′ -155° 40,696′", $this->formatter->format($coordinate));
    }
}
