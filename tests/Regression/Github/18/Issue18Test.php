<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class Issue18Test extends TestCase
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
