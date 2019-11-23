<?php

declare(strict_types=1);

namespace Location\Formatter\Coordinate;

use Location\Coordinate;
use PHPUnit\Framework\TestCase;

class DecimalDegreesTest extends TestCase
{
    /**
     * @var DecimalDegrees
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new DecimalDegrees();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testFormatDefaultSeparator()
    {
        $coordinate = new Coordinate(52.5, 13.5);

        $formatter = new DecimalDegrees();

        $this->assertEquals('52.50000 13.50000', $formatter->format($coordinate));
    }

    public function testFormatCustomSeparator()
    {
        $coordinate = new Coordinate(52.5, 13.5);

        $formatter = new DecimalDegrees(', ');

        $this->assertEquals('52.50000, 13.50000', $formatter->format($coordinate));
    }

    public function testIfSetSeparatorWorksAsExpected()
    {
        $coordinate = new Coordinate(52.5, 13.5);

        $formatter = new DecimalDegrees();
        $formatter->setSeparator('/');

        $this->assertEquals('52.50000/13.50000', $formatter->format($coordinate));
    }
}
