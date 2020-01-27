<?php

declare(strict_types=1);

namespace Location\Formatter\Polyline;

use Location\Coordinate;
use Location\Polyline;
use PHPUnit\Framework\TestCase;

class GeoJSONTest extends TestCase
{
    /**
     * @var GeoJSON
     */
    protected $formatter;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->formatter = new GeoJSON();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        unset($this->formatter);
    }

    public function testFormatDefault(): void
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(52.5, 13.5));
        $polyline->addPoint(new Coordinate(62.5, 14.5));

        $json = '{ "type" : "LineString" , "coordinates" : [ [ 13.5, 52.5 ], [ 14.5, 62.5 ] ] }';

        $this->assertJsonStringEqualsJsonString($json, $this->formatter->format($polyline));
    }
}
