<?php

declare(strict_types=1);

namespace Location\Utility;

use Location\Bearing\BearingSpherical;
use Location\Coordinate;
use Location\Distance\DistanceInterface;
use Location\Distance\Vincenty;
use Location\Exception\NotConvergingException;
use Location\Line;

use function PHPUnit\Framework\throwException;

/**
 * Calculate the distance between a Line (minor arc of a Great Circle) and a Point.
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class PointToLineDistance
{
    /**
     * @var DistanceInterface
     */
    private $distanceCalculator;

    /**
     * @var float
     */
    private $epsilon;

    public function __construct(DistanceInterface $distanceCalculator, float $epsilon = 0.001)
    {
        $this->distanceCalculator = $distanceCalculator;
        $this->epsilon = $epsilon;
    }

    /**
     * @psalm-suppress InvalidReturnType
     * @throws NotConvergingException
     */
    public function getDistance(Coordinate $point, Line $line): float
    {
        if ($line->getPoint1()->hasSameLocation($line->getPoint2(), $this->epsilon)) {
            return $this->distanceCalculator->getDistance($point, $line->getPoint1());
        }
        if ($point->hasSameLocation($line->getPoint1(), $this->epsilon)) {
            return 0.0;
        }
        if ($point->hasSameLocation($line->getPoint2(), $this->epsilon)) {
            return 0.0;
        }
        if ($point->hasSameLocation($line->getMidpoint(), $this->epsilon)) {
            return 0.0;
        }

        $iterationsCounter = 0;
        $iterationLine = clone $line;

        do {
            $linePoint1 = $iterationLine->getPoint1();
            $linePoint2 = $iterationLine->getPoint2();
            $lineMidPoint = $iterationLine->getMidpoint();

            $distancePointToLinePoint1 = $point->getDistance($linePoint1, $this->distanceCalculator);
            $distancePointToLinePoint2 = $point->getDistance($linePoint2, $this->distanceCalculator);

            if ($distancePointToLinePoint1 <= $distancePointToLinePoint2) {
                $iterationLine = new Line($linePoint1, $lineMidPoint);
            } else {
                $iterationLine = new Line($lineMidPoint, $linePoint2);
            }

            if (abs($distancePointToLinePoint1 - $distancePointToLinePoint2) < $this->epsilon) {
                return $point->getDistance($iterationLine->getMidpoint(), $this->distanceCalculator);
            }

            $iterationsCounter++;
            if ($iterationsCounter > 100) {
                throw new NotConvergingException(
                    'Calculation of Point to Minor Arc did not converge after 100 iterations.',
                    6391878367
                );
            }
        } while (true);
    }
}
