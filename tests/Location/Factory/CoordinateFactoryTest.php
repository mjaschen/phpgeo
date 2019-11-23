<?php

declare(strict_types=1);

namespace Location\Factory;

use Location\Coordinate;
use PHPUnit\Framework\TestCase;

class CoordinateFactoryTest extends TestCase
{
    public function testIfFromStringForDecimalDegreesWorksAsExpected()
    {
        $this->assertEquals(new Coordinate(52, 13), CoordinateFactory::fromString('52, 13'));
        $this->assertEquals(new Coordinate(52, 13), CoordinateFactory::fromString('52 13'));
        $this->assertEquals(new Coordinate(52, 13), CoordinateFactory::fromString('52 013'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5, 13.5'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5 13.5'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5°, 13.5°'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5° 13.5°'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5° 013.5°'));
        $this->assertEquals(new Coordinate(-52.5, 13.5), CoordinateFactory::fromString('-52.5, 13.5'));
        $this->assertEquals(new Coordinate(-52.5, 13.5), CoordinateFactory::fromString('-52.5 13.5'));
        $this->assertEquals(new Coordinate(-52.5, 13.5), CoordinateFactory::fromString('-52.5 013.5'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('-52.5, -13.5'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('-52.5 -13.5'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('-52.5 -013.5'));
        $this->assertEquals(new Coordinate(52.5, -13.5), CoordinateFactory::fromString('52.5, -13.5'));
        $this->assertEquals(new Coordinate(52.5, -13.5), CoordinateFactory::fromString('52.5 -13.5'));
    }

    public function testIfFromStringForDecimalDegreesWithCardinalLettersWorksAsExpected()
    {
        $this->assertEquals(new Coordinate(52, 13), CoordinateFactory::fromString('N52, E13'));
        $this->assertEquals(new Coordinate(52, 13), CoordinateFactory::fromString('N52 E13'));
        $this->assertEquals(new Coordinate(52, 13), CoordinateFactory::fromString('N52 E013'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('N52.5, E13.5'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('N52.5 E13.5'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('N52.5°, E13.5°'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('N52.5° E13.5°'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('N52.5° E013.5°'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5N, 13.5E'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5N 13.5E'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5N 013.5E'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5°N, 13.5°E'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5°N 13.5°E'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5°N 013.5°E'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5° N, 13.5° E'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5° N 13.5° E'));
        $this->assertEquals(new Coordinate(52.5, 13.5), CoordinateFactory::fromString('52.5° N 013.5° E'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('S52.5, W13.5'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('S52.5 W13.5'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('52.5S, 13.5W'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('52.5S 13.5W'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('52.5S 013.5W'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('S 52.5, W 13.5'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('S 52.5 W 13.5'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('S 52.5 W 013.5'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('52.5 S, 13.5 W'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('52.5 S 13.5 W'));
        $this->assertEquals(new Coordinate(-52.5, -13.5), CoordinateFactory::fromString('52.5 S 013.5 W'));
    }

    public function testIfFromStringWithDecimalMinutesWorksAsExpected()
    {
        $expected = new Coordinate(52.20575, 13.576116667);
        $expectedLat = $expected->getLat();
        $expectedLng = $expected->getLng();

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('52 12.345, 13 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('52 12.345, 13 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            -$expectedLat,
            CoordinateFactory::fromString('-52 12.345, 13 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('-52 12.345, 13 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            -$expectedLat,
            CoordinateFactory::fromString('-52 12.345, -13 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            -$expectedLng,
            CoordinateFactory::fromString('-52 12.345, -13 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('52 12.345, -13 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            -$expectedLng,
            CoordinateFactory::fromString('52 12.345, -13 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('52° 12.345, 13° 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('52° 12.345, 13° 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            -$expectedLat,
            CoordinateFactory::fromString('-52° 12.345, 13° 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('-52° 12.345, 13° 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            -$expectedLat,
            CoordinateFactory::fromString('-52° 12.345, -13° 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            -$expectedLng,
            CoordinateFactory::fromString('-52° 12.345, -13° 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('52° 12.345, -13° 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            -$expectedLng,
            CoordinateFactory::fromString('52° 12.345, -13° 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('N52 12.345, E13 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('N52 12.345, E13 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('N 52 12.345, E 13 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('N 52 12.345, E 13 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('52 12.345N, E13 34.567E')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('52 12.345N, E13 34.567E')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('52 12.345 N, E13 34.567 E')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('52 12.345 N, E13 34.567 E')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('N52° 12.345, E13° 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('N52° 12.345, E13° 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('N 52° 12.345, E 13° 34.567')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('N 52° 12.345, E 13° 34.567')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('52° 12.345N, E13° 34.567E')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('52° 12.345N, E13° 34.567E')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('52° 12.345 N, E13° 34.567 E')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('52° 12.345 N, E13° 34.567 E')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString("N52° 12.345', E13° 34.567'")->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString("N52° 12.345', E13° 34.567'")->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString("N 52° 12.345', E 13° 34.567'")->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString("N 52° 12.345', E 13° 34.567'")->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString("52° 12.345' N, E13° 34.567' E")->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString("52° 12.345' N, E13° 34.567' E")->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('N52° 12.345′, E13° 34.567′')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('N52° 12.345′, E13° 34.567′')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('N 52° 12.345′, E 13° 34.567′')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('N 52° 12.345′, E 13° 34.567′')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            $expectedLat,
            CoordinateFactory::fromString('52° 12.345′ N, E13° 34.567′ E')->getLat(),
            '',
            0.0001
        );
        $this->assertEquals(
            $expectedLng,
            CoordinateFactory::fromString('52° 12.345′ N, E13° 34.567′ E')->getLng(),
            '',
            0.0001
        );

        $this->assertEquals(
            new Coordinate(52.2333, 20.9756),
            CoordinateFactory::fromString('52° 13.998′ 020° 58.536′')
        );
    }

    /**
     * @dataProvider dataIfFromStringWithIntegerMinutesAndDecimalSecondsWorksAsExpected
     *
     * @param float $expectedLat
     * @param float $expectedLng
     * @param string $string
     */
    public function testIfFromStringWithIntegerMinutesAndDecimalSecondsWorksAsExpected(
        $expectedLat,
        $expectedLng,
        $string
    ) {
        $coordinate = CoordinateFactory::fromString($string);
        $this->assertEquals($expectedLat, $coordinate->getLat(), '', 0.0001);
        $this->assertEquals($expectedLng, $coordinate->getLng(), '', 0.0001);
    }

    /**
     * Data provider for decimal seconds parser test.
     */
    public function dataIfFromStringWithIntegerMinutesAndDecimalSecondsWorksAsExpected()
    {
        $expected = new Coordinate(52.20575, 13.576116667);
        $expectedLat = $expected->getLat();
        $expectedLng = $expected->getLng();

        $testData = [
            '52 12 20.7, 13 34 34.02',
            '52 12 20.7N, 13 34 34.02E',
            '52 12 20.7 N, E13 34 34.02 E',
            '52° 12\' 20.7" N, E13° 34\' 34.02" E',
            '52° 12\' 20.7\'\' N, E13° 34\' 34.02\'\' E',
            '52° 12′ 20.7″ N, E13° 34′ 34.02″ E',
            '52° 12′ 20.7′′ N, E13° 34′ 34.02′′ E',
        ];

        foreach ($testData as $string) {
            yield $string => [$expectedLat, $expectedLng, $string];
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIfInvalidFormatThrowsException()
    {
        CoordinateFactory::fromString('Lorem ipsum dolor sit amet');
    }
}
