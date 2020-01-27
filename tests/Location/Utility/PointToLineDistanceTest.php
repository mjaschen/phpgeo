<?php

declare(strict_types=1);

namespace Location\Utility;

use Location\Coordinate;
use Location\Distance\Vincenty;
use Location\Line;
use PHPUnit\Framework\TestCase;

class PointToLineDistanceTest extends TestCase
{
    /**
     * @var PointToLineDistance
     */
    private $pointToLineDistance;

    /**
     * @var Vincenty
     */
    private $vincenty;

    public function setUp(): void
    {
        parent::setUp();

        $this->vincenty = new Vincenty();
        $this->pointToLineDistance = new PointToLineDistance($this->vincenty);
    }

    public function testLineHasTheSameStartAndEndPoint(): void
    {
        $point = new Coordinate(52.5, 13.5);

        $line = new Line(new Coordinate(52.5, 13.1), new Coordinate(52.5, 13.1));

        $this->assertEquals(27164.059, $this->pointToLineDistance->getDistance($point, $line));
    }

    public function testLinePoint1IsNearer(): void
    {
        $point = new Coordinate(52.45, 13.05);

        $linePoint1 = new Coordinate(52.5, 13.1);
        $linePoint2 = new Coordinate(52.6, 13.12);
        $line = new Line($linePoint1, $linePoint2);

        $this->assertEquals(
            $point->getDistance($linePoint1, $this->vincenty),
            $this->pointToLineDistance->getDistance($point, $line)
        );
    }

    public function testLinePoint2IsNearer(): void
    {
        $point = new Coordinate(52.6001, 13.1201);

        $linePoint1 = new Coordinate(52.5, 13.1);
        $linePoint2 = new Coordinate(52.6, 13.12);
        $line = new Line($linePoint1, $linePoint2);

        $this->assertEquals(
            $point->getDistance($linePoint2, $this->vincenty),
            $this->pointToLineDistance->getDistance($point, $line)
        );
    }

    public function testDistanceIsCalculatedToSomewhereOnLine(): void
    {
        $point = new Coordinate(52.04, 13.01);

        $linePoint1 = new Coordinate(52.0, 13.0);
        $linePoint2 = new Coordinate(52.07, 13.02);
        $line = new Line($linePoint1, $linePoint2);

        $pl1Distance = $point->getDistance($linePoint1, $this->vincenty);
        $pl2Distance = $point->getDistance($linePoint2, $this->vincenty);
        $plDistance = $this->pointToLineDistance->getDistance($point, $line);

        $this->assertLessThan($pl1Distance, $plDistance);
        $this->assertLessThan($pl2Distance, $plDistance);
    }

    public function testDistanceMatchesPerpendicularDistance(): void
    {
        $point = new Coordinate(52.04, 13.01);

        $linePoint1 = new Coordinate(52.0, 13.0);
        $linePoint2 = new Coordinate(52.07, 13.02);
        $line = new Line($linePoint1, $linePoint2);

        $pdCalculator = new PerpendicularDistance();

        $perpendicularDistance = $pdCalculator->getPerpendicularDistance($point, $line);
        $pointToLineDistance = $this->pointToLineDistance->getDistance($point, $line);

        $this->assertEquals($pointToLineDistance, $perpendicularDistance);
    }
}
