<?php

declare(strict_types=1);

namespace Location;

use Location\Distance\Vincenty;
use Location\Exception\NotConvergingException;
use Location\Utility\PointToLineDistance;
use PHPUnit\Framework\TestCase;

class Issue107Test extends TestCase
{
    /**
     * Nearly antipodal points can cause the Vincenty formula to not converge.
     *
     * @see http://www.movable-type.co.uk/scripts/latlong-vincenty.html
     * @see https://archive.ph/jrxcA
     */
    public function testForIssue107(): void
    {
        $this->expectException(NotConvergingException::class);

        $coordinate1 = new Coordinate(-5.59248, -78.774002);
        $coordinate2 = new Coordinate(5.79, 101.15);

        $coordinate1->getDistance($coordinate2, new Vincenty());
    }
}
