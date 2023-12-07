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

    public static function getCardinalDirectionDistancesProvider(): Generator
    {
        $point2 = new Coordinate(51, 13);

        $directDistanceWestEast = 70197.14;

        yield 'point1 equals point2' => [
            'point1' => $point2,
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create(),
        ];
        yield 'point1 north from point2' => [
            'point1' => self::moveToNorth($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setSouth(111257.827),
        ];
        yield 'point1 east from point2' => [
            'point1' => self::moveToEast($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setWest($directDistanceWestEast),
        ];
        yield 'point1 south from point2' => [
            'point1' => self::moveToSouth($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setNorth(111238.681),
        ];
        yield 'point1 west from point2' => [
            'point1' => self::moveToWest($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setEast($directDistanceWestEast),
        ];
        yield 'point1 north west from point2' => [
            'point1' => self::moveToNorthWest($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setEast(68677.475)->setSouth(111257.827),
        ];
        yield 'point1 north east from point2' => [
            'point1' => self::moveToNorthEast($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setSouth(111257.827)->setWest(68677.475),
        ];
        yield 'point1 south east from point2' => [
            'point1' => self::moveToSouthEast($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setNorth(111238.681)->setWest(71695.22),
        ];
        yield 'point1 south west from point2' => [
            'point1' => self::moveToSouthWest($point2),
            'point2' => $point2,
            'expected' => CardinalDirectionDistances::create()->setNorth(111238.681)->setEast(71695.22),
        ];
    }

    private static function moveToNorth(Coordinate $coordinate): Coordinate
    {
        return new Coordinate($coordinate->getLat() + 1, $coordinate->getLng());
    }

    private static function moveToEast(Coordinate $coordinate): Coordinate
    {
        return new Coordinate($coordinate->getLat(), $coordinate->getLng() + 1);
    }

    private static function moveToSouth(Coordinate $coordinate): Coordinate
    {
        return new Coordinate($coordinate->getLat() - 1, $coordinate->getLng());
    }

    private static function moveToWest(Coordinate $coordinate): Coordinate
    {
        return new Coordinate($coordinate->getLat(), $coordinate->getLng() - 1);
    }

    private static function moveToNorthEast(Coordinate $coordinate): Coordinate
    {
        return self::moveToNorth(self::moveToEast($coordinate));
    }

    private static function moveToSouthEast(Coordinate $coordinate): Coordinate
    {
        return self::moveToSouth(self::moveToEast($coordinate));
    }

    private static function moveToSouthWest(Coordinate $coordinate): Coordinate
    {
        return self::moveToSouth(self::moveToWest($coordinate));
    }

    private static function moveToNorthWest(Coordinate $coordinate): Coordinate
    {
        return self::moveToNorth(self::moveToWest($coordinate));
    }
}
