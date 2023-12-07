<?php

declare(strict_types=1);

namespace Location\CardinalDirection;

use Generator;
use Location\Coordinate;
use PHPUnit\Framework\TestCase;

class CardinalDirectionTest extends TestCase
{
    /** @dataProvider getCardinalDirectionProvider */
    public function testGetCardinalDirection(Coordinate $point1, Coordinate $point2, string $expected): void
    {
        $this->assertSame(
            $expected,
            (new CardinalDirection())->getCardinalDirection($point1, $point2)
        );
    }

    public static function getCardinalDirectionProvider(): Generator
    {
        $point2 = new Coordinate(51, 13);
        yield 'point1 equals point2' => [
            'point1' => $point2,
            'point2' => $point2,
            'expected' => CardinalDirection::CARDINAL_DIRECTION_NONE,
        ];
        yield 'point1 north from point2' => [
            'point1' => self::moveToNorth($point2),
            'point2' => $point2,
            'expected' => CardinalDirection::CARDINAL_DIRECTION_NORTH,
        ];
        yield 'point1 east from point2' => [
            'point1' => self::moveToEast($point2),
            'point2' => $point2,
            'expected' => CardinalDirection::CARDINAL_DIRECTION_EAST,
        ];
        yield 'point1 south from point2' => [
            'point1' => self::moveToSouth($point2),
            'point2' => $point2,
            'expected' => CardinalDirection::CARDINAL_DIRECTION_SOUTH,
        ];
        yield 'point1 west from point2' => [
            'point1' => self::moveToWest($point2),
            'point2' => $point2,
            'expected' => CardinalDirection::CARDINAL_DIRECTION_WEST,
        ];
        yield 'point1 north west from point2' => [
            'point1' => self::moveToNorthWest($point2),
            'point2' => $point2,
            'expected' => CardinalDirection::CARDINAL_DIRECTION_NORTHWEST,
        ];
        yield 'point1 north east from point2' => [
            'point1' => self::moveToNorthEast($point2),
            'point2' => $point2,
            'expected' => CardinalDirection::CARDINAL_DIRECTION_NORTHEAST,
        ];
        yield 'point1 south east from point2' => [
            'point1' => self::moveToSouthEast($point2),
            'point2' => $point2,
            'expected' => CardinalDirection::CARDINAL_DIRECTION_SOUTHEAST,
        ];
        yield 'point1 south west from point2' => [
            'point1' => self::moveToSouthWest($point2),
            'point2' => $point2,
            'expected' => CardinalDirection::CARDINAL_DIRECTION_SOUTHWEST,
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
