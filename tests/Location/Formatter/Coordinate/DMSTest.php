<?php

declare(strict_types=1);

namespace Location\Formatter\Coordinate;

use InvalidArgumentException;
use Location\Coordinate;
use PHPUnit\Framework\TestCase;

class DMSTest extends TestCase
{
    /**
     * @var DMS
     */
    protected $formatter;

    protected function setUp(): void
    {
        $this->formatter = new DMS();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }

    public function testSetUnitsUTF8(): void
    {
        $this->formatter->setUnits(DMS::UNITS_UTF8);

        $this->assertEquals(DMS::UNITS_UTF8, $this->formatter->getUnitType());
    }

    public function testSetUnitsASCII(): void
    {
        $this->formatter->setUnits(DMS::UNITS_ASCII);

        $this->assertEquals(DMS::UNITS_ASCII, $this->formatter->getUnitType());
    }

    public function testSetUnitsInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid unit type');


        $this->formatter->setUnits('invalid');
    }

    public function testFormatDefaultSeparator(): void
    {
        $coordinate = new Coordinate(52.5, 13.5);

        $this->assertEquals('52° 30′ 00″ 013° 30′ 00″', $this->formatter->format($coordinate));
    }

    public function testFormatCustomSeparator(): void
    {
        $coordinate = new Coordinate(18.911306, - 155.678268);

        $this->formatter->setSeparator(', ');

        $this->assertEquals('18° 54′ 41″, -155° 40′ 42″', $this->formatter->format($coordinate));
    }

    public function testFormatCardinalLetters(): void
    {
        $coordinate = new Coordinate(18.911306, - 155.678268);

        $this->formatter->setSeparator(', ')->useCardinalLetters(true);

        $this->assertEquals('18° 54′ 41″ N, 155° 40′ 42″ W', $this->formatter->format($coordinate));
    }

    public function testFormatBothNegative(): void
    {
        $coordinate = new Coordinate(- 18.911306, - 155.678268);

        $this->formatter->setSeparator(', ');

        $this->assertEquals('-18° 54′ 41″, -155° 40′ 42″', $this->formatter->format($coordinate));
    }

    public function testFormatASCIIUnits(): void
    {
        $coordinate = new Coordinate(- 18.911306, - 155.678268);

        $this->formatter->setSeparator(', ')->setUnits(DMS::UNITS_ASCII);

        $this->assertEquals("-18° 54' 41\", -155° 40' 42\"", $this->formatter->format($coordinate));
    }
}
