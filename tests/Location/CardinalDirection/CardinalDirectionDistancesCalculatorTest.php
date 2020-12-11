<?php

declare(strict_types=1);

namespace Location\CardinalDirection;

use Generator;
use Location\Coordinate;
use Location\Distance\Vincenty;
use PHPUnit\Framework\TestCase;

class CardinalDirectionDistancesCalculatorTest extends TestCase
{
    /** @dataProvider getCardinalDirectionDistancesProvider */
    public function testGetCardinalDirectionDistances(
        Coordinate $point1,
        Coordinate $point2,
        CardinalDirectionDistances $expected
    ): void {
        $cardinalDirectionDistancesCalculator = new CardinalDirectionDistancesCalculator();

        $this->assertEquals(
            $expected,
            $cardinalDirectionDistancesCalculator->getCardinalDirectionDistances($point1, $point2, new Vincenty())
        );
    }

    public function getCardinalDirectionDistancesProvider(): Generator
    {
        $point2 = new Coordinate(51, 13);

        $directDistanceWestEast = 70197.14;

        yield 'point1 equals point2' => [
            'point1' => $point2,
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create(),
        ];
        yield 'point1 north from point2' => [
            'point1' => $this->moveToNorth($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setSouth(111257.827),
        ];
        yield 'point1 east from point2' => [
            'point1' => $this->moveToEast($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setWest($directDistanceWestEast),
        ];
        yield 'point1 south from point2' => [
            'point1' => $this->moveToSouth($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setNorth(111238.681),
        ];
        yield 'point1 west from point2' => [
            'point1' => $this->moveToWest($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setEast($directDistanceWestEast),
        ];
        yield 'point1 north west from point2' => [
            'point1' => $this->moveToNorthWest($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setEast(68677.475)->setSouth(111257.827),
        ];
        yield 'point1 north east from point2' => [
            'point1' => $this->moveToNorthEast($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setSouth(111257.827)->setWest(68677.475),
        ];
        yield 'point1 south east from point2' => [
            'point1' => $this->moveToSouthEast($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setNorth(111238.681)->setWest(71695.22),
        ];
        yield 'point1 south west from point2' => [
            'point1' => $this->moveToSouthWest($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setNorth(111238.681)->setEast(71695.22),
        ];
    }

    private function moveToNorth(Coordinate $coordinate): Coordinate
    {
        return new Coordinate($coordinate->getLat() + 1, $coordinate->getLng());
    }

    private function moveToEast(Coordinate $coordinate): Coordinate
    {
        return new Coordinate($coordinate->getLat(), $coordinate->getLng() + 1);
    }

    private function moveToSouth(Coordinate $coordinate): Coordinate
    {
        return new Coordinate($coordinate->getLat() - 1, $coordinate->getLng());
    }

    private function moveToWest(Coordinate $coordinate): Coordinate
    {
        return new Coordinate($coordinate->getLat(), $coordinate->getLng() - 1);
    }

    private function moveToNorthEast(Coordinate $coordinate): Coordinate
    {
        return self::moveToNorth(self::moveToEast($coordinate));
    }

    private function moveToSouthEast(Coordinate $coordinate): Coordinate
    {
        return self::moveToSouth(self::moveToEast($coordinate));
    }

    private function moveToSouthWest(Coordinate $coordinate): Coordinate
    {
        return self::moveToSouth(self::moveToWest($coordinate));
    }

    private function moveToNorthWest(Coordinate $coordinate): Coordinate
    {
        return self::moveToNorth(self::moveToWest($coordinate));
    }
}
