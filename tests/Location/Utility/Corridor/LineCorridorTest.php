<?php

use Location\Bearing\BearingEllipsoidal;
use Location\Coordinate;
use Location\Line;
use Location\Utility\Corridor\LineCorridor;

class LineCorridorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIfZeroDistanceThrowsAnException()
    {
        $instance = new LineCorridor(0, new BearingEllipsoidal());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIfNegativeDistanceThrowsAnException()
    {
        $instance = new LineCorridor(-1, new BearingEllipsoidal());
    }

    public function testIfSimpleLineCorridorWorksAsExpected()
    {
        $line = new Line(
            new Coordinate(0, 0),
            new Coordinate(0.1, 0.1)
        );

        $instance = new LineCorridor(1000, new BearingEllipsoidal());

        $corridor = $instance->createCorridor($line);
    }
}
