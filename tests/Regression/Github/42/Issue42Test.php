<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class Issue42Test extends TestCase
{
    public function testIfIssue42IsFixed()
    {
        $vincenty = new \Location\Distance\Vincenty();

        $distance = $vincenty->getDistance(
            new \Location\Coordinate(45.306833,5.887717),
            new \Location\Coordinate(45.306833,5.887733)
        );

        $this->assertEquals(1.255, $distance);
    }
}
