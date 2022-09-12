<?php

declare(strict_types=1);

namespace Location;

use PHPUnit\Framework\TestCase;

class Issue96Test extends TestCase
{
    public function testForIssue96(): void
    {
        $line1 = new Line(
            new Coordinate(0.0, 0.0),
            new Coordinate(0.0, 2.0)
        );
        $line2 = new Line(
            new Coordinate(2.0, 2.0),
            new Coordinate(0.0, 10.0)
        );

        //$this->assertFalse($line1->intersectsLine($line2));

        $line1 = new Line(
            new Coordinate(0.0, 0.0),
            new Coordinate(0.0, 1.999999)
        );
        $line2 = new Line(
            new Coordinate(2.0, 2.0),
            new Coordinate(0.0, 10.0)
        );

        //$this->assertFalse($line1->intersectsLine($line2));
    }
}
