<?php

declare(strict_types=1);

namespace Location\CardinalDirection;

use Location\Exception\InvalidDistanceException;
use PHPUnit\Framework\TestCase;

class CardinalDirectionDistancesTest extends TestCase
{
    public function testSetNorth(): void
    {
        $north = 2500.0;
        $this->assertSame($north, CardinalDirectionDistances::create()->setNorth($north)->getNorth());
    }

    public function testSetNorthThrows(): void
    {
        $this->expectException(InvalidDistanceException::class);
        CardinalDirectionDistances::create()->setNorth(-1);
    }

    public function testSetEast(): void
    {
        $east = 2500.0;
        $this->assertSame($east, CardinalDirectionDistances::create()->setEast($east)->getEast());
    }

    public function testSetEastThrows(): void
    {
        $this->expectException(InvalidDistanceException::class);
        CardinalDirectionDistances::create()->setEast(-1);
    }

    public function testSetSouth(): void
    {
        $south = 2500.0;
        $this->assertSame($south, CardinalDirectionDistances::create()->setSouth($south)->getSouth());
    }

    public function testSetSouthThrows(): void
    {
        $this->expectException(InvalidDistanceException::class);
        CardinalDirectionDistances::create()->setSouth(-1);
    }

    public function testSetWest(): void
    {
        $west = 2500.0;
        $this->assertSame($west, CardinalDirectionDistances::create()->setWest($west)->getWest());
    }

    public function testSetWestThrows(): void
    {
        $this->expectException(InvalidDistanceException::class);
        CardinalDirectionDistances::create()->setWest(-1);
    }

    public function testSetMultiple(): void
    {
        $north = 500.0;
        $east = 1000.0;
        $south = 1500.0;
        $west = 2000.0;
        $cardinalDirectionDistances = CardinalDirectionDistances::create()
            ->setNorth($north)
            ->setEast($east)
            ->setSouth($south)
            ->setWest($west);

        $this->assertSame($north, $cardinalDirectionDistances->getNorth());
        $this->assertSame($east, $cardinalDirectionDistances->getEast());
        $this->assertSame($south, $cardinalDirectionDistances->getSouth());
        $this->assertSame($west, $cardinalDirectionDistances->getWest());
    }
}
