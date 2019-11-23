<?php

declare(strict_types=1);

namespace Location\Formatter\Coordinate;

use Location\Coordinate;
use PHPUnit\Framework\TestCase;

class DMSTest extends TestCase
{
    /**
     * @var DMS
     */
    protected $formatter;

    protected function setUp()
    {
        $this->formatter = new DMS();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testSetUnitsUTF8()
    {
        $this->formatter->setUnits(DMS::UNITS_UTF8);

        $this->assertAttributeSame(DMS::UNITS_UTF8, 'unitType', $this->formatter);
    }

    public function testSetUnitsASCII()
    {
        $this->formatter->setUnits(DMS::UNITS_ASCII);

        $this->assertAttributeSame(DMS::UNITS_ASCII, 'unitType', $this->formatter);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid unit type
     */
    public function testSetUnitsInvalidType()
    {
        $this->formatter->setUnits('invalid');
    }

    public function testFormatDefaultSeparator()
    {
        $coordinate = new Coordinate(52.5, 13.5);

        $this->assertEquals('52° 30′ 00″ 013° 30′ 00″', $this->formatter->format($coordinate));
    }

    public function testFormatCustomSeparator()
    {
        $coordinate = new Coordinate(18.911306, - 155.678268);

        $this->formatter->setSeparator(', ');

        $this->assertEquals('18° 54′ 41″, -155° 40′ 42″', $this->formatter->format($coordinate));
    }

    public function testFormatCardinalLetters()
    {
        $coordinate = new Coordinate(18.911306, - 155.678268);

        $this->formatter->setSeparator(', ')->useCardinalLetters(true);

        $this->assertEquals('18° 54′ 41″ N, 155° 40′ 42″ W', $this->formatter->format($coordinate));
    }

    public function testFormatBothNegative()
    {
        $coordinate = new Coordinate(- 18.911306, - 155.678268);

        $this->formatter->setSeparator(', ');

        $this->assertEquals('-18° 54′ 41″, -155° 40′ 42″', $this->formatter->format($coordinate));
    }

    public function testFormatASCIIUnits()
    {
        $coordinate = new Coordinate(- 18.911306, - 155.678268);

        $this->formatter->setSeparator(', ')->setUnits(DMS::UNITS_ASCII);

        $this->assertEquals("-18° 54' 41\", -155° 40' 42\"", $this->formatter->format($coordinate));
    }
}
