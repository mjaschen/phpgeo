<?php

declare(strict_types=1);

namespace Location;

use PHPUnit\Framework\TestCase;

class LineIntersectionTest extends TestCase
{
    public function testIntersectsLineSimpleCrossing(): void
    {
        $line1 = new Line(new Coordinate(0, 0), new Coordinate(10, 10));
        $line2 = new Line(new Coordinate(0, 10), new Coordinate(10, 0));

        $this->assertTrue($line1->intersectsLine($line2));
    }

    public function testIntersectsLineParallelDisjoint(): void
    {
        $line1 = new Line(new Coordinate(0, 0), new Coordinate(10, 0));
        $line2 = new Line(new Coordinate(0, 1), new Coordinate(10, 1));

        $this->assertFalse($line1->intersectsLine($line2));
    }

    public function testIntersectsLineCollinearOverlapping(): void
    {
        $line1 = new Line(new Coordinate(0, 0), new Coordinate(10, 0));
        $line2 = new Line(new Coordinate(5, 0), new Coordinate(15, 0));

        $this->assertTrue($line1->intersectsLine($line2));
    }

    public function testIntersectsLineCollinearDisjoint(): void
    {
        $line1 = new Line(new Coordinate(0, 0), new Coordinate(10, 0));
        $line2 = new Line(new Coordinate(12, 0), new Coordinate(15, 0));

        $this->assertFalse($line1->intersectsLine($line2));
    }

    public function testIntersectsLineSharingEndpoint(): void
    {
        $line1 = new Line(new Coordinate(0, 0), new Coordinate(10, 0));
        $line2 = new Line(new Coordinate(10, 0), new Coordinate(10, 10));

        $this->assertTrue($line1->intersectsLine($line2));
    }

    public function testIntersectsLineTJunction(): void
    {
        $line1 = new Line(new Coordinate(0, 0), new Coordinate(10, 0));
        $line2 = new Line(new Coordinate(5, 0), new Coordinate(5, 5));

        $this->assertTrue($line1->intersectsLine($line2));
    }

    public function testIntersectsLineDatelineCrossing(): void
    {
        $line1 = new Line(new Coordinate(0, 179), new Coordinate(0, -179));
        $line2 = new Line(new Coordinate(1, 180), new Coordinate(-1, 180));

        $this->assertTrue($line1->intersectsLine($line2));
    }
}
