<?php

namespace Location\Formatter\Polyline;

use Location\Coordinate;
use Location\Polyline;

class GeoJSONTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GeoJSON
     */
    protected $formatter;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->formatter = new GeoJSON;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->formatter);
    }

    /**
     * @covers Location\Formatter\Coordinate\DecimalDegrees::format
     */
    public function testFormatDefault()
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Coordinate(52.5, 13.5));
        $polyline->addPoint(new Coordinate(62.5, 14.5));

        $json = '{ "type" : "LineString" , "coordinates" : [ [ 13.5, 52.5 ], [ 14.5, 62.5 ] ] }';

        $this->assertJsonStringEqualsJsonString($json, $this->formatter->format($polyline));
    }
}
