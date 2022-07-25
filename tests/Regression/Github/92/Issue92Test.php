<?php

declare(strict_types=1);

namespace Location;

use Location\Distance\Vincenty;
use Location\Utility\PointToLineDistance;
use PHPUnit\Framework\TestCase;

class Issue92Test extends TestCase
{
    public function testForIssue92(): void
    {
        $ll1 = [
            'lat' => 55.98467000751469413444283418357372283935546875,
            'lon' => 13.544430000324179985682349069975316524505615234375,
        ];
        $ll2 = [
            'lat' => 55.98461833972562118333371472544968128204345703125,
            'lon' => 13.54429500218709137016048771329224109649658203125,
        ];
        $p = [
            'lat' => 55.97609299999999876717993174679577350616455078125,
            'lon' => 13.5475989999999999469082467840053141117095947265625,
        ];

        $pointToLineDistanceCalculator = new PointToLineDistance(new Vincenty());

        $dist = $pointToLineDistanceCalculator->getDistance(
            new Coordinate($p['lat'], $p['lon']),
            new Line(
                new Coordinate($ll1['lat'], $ll1['lon']),
                new Coordinate($ll2['lat'], $ll2['lon'])
            )
        );

        $this->assertEqualsWithDelta(971.37, $dist, 0.01);
    }

    public function testForIssue92RoundedValues(): void
    {
        $ll1 = [
            'lat' => 55.98467,
            'lon' => 13.54443,
        ];
        $ll2 = [
            'lat' => 55.98461,
            'lon' => 13.54429,
        ];
        $p = [
            'lat' => 55.97609,
            'lon' => 13.54759,
        ];

        $pointToLineDistanceCalculator = new PointToLineDistance(new Vincenty());

        $dist = $pointToLineDistanceCalculator->getDistance(
            new Coordinate($p['lat'], $p['lon']),
            new Line(
                new Coordinate($ll1['lat'], $ll1['lon']),
                new Coordinate($ll2['lat'], $ll2['lon'])
            )
        );

        $this->assertEqualsWithDelta(970.74, $dist, 0.01);
    }
}
