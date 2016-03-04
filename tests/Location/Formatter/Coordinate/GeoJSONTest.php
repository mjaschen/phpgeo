<?php

namespace Location\Formatter\Coordinate;

use Location\Coordinate;

class GeoJSONTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DecimalDegrees
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
     * @covers Location\Formatter\Coordinate\GeoJSON::format
     */
    public function testFormatDefault()
    {
        $coordinate = new Coordinate(52.5, 13.5);

        $json = '{ "type" : "Point" , "coordinates" : [ 13.5, 52.5 ] }';

        $this->assertJsonStringEqualsJsonString($json, $this->formatter->format($coordinate));
    }

    /**
     * @covers Location\Formatter\Coordinate\GeoJSON::format
     */
    public function testFormatPrecision()
    {
        $coordinate = new Coordinate(52.123456789012345, 13.123456789012345);

        $json = '{ "type" : "Point" , "coordinates" : [ 13.123456789012345, 52.123456789012345 ] }';

        $this->assertJsonStringEqualsJsonString($json, $this->formatter->format($coordinate));
    }
}
