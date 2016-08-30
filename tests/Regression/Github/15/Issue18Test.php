<?php

class Issue18Test extends \PHPUnit_Framework_TestCase
{
    public function testIfIssue18IsFixed()
    {
        $vincenty = new \Location\Distance\Vincenty();

        $distance = $vincenty->getDistance(
            new \Location\Coordinate(0, 0),
            new \Location\Coordinate(0, 0.1)
        );

        $this->assertInternalType('float', $distance);
    }
}
