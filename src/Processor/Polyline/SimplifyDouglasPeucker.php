<?php

declare(strict_types=1);

namespace Location\Processor\Polyline;

use Location\Coordinate;
use Location\GeometryInterface;
use Location\Line;
use Location\Polygon;
use Location\Polyline;
use Location\Utility\PerpendicularDistance;
use RuntimeException;

/**
 * Simplify Polyline with the Douglas-Peucker-Algorithm
 *
 * The Algorithm is described here:
 * http://en.wikipedia.org/wiki/Ramer%E2%80%93Douglas%E2%80%93Peucker_algorithm
 *
 * The formula for the Perpendicular Distance is described here:
 * http://biodiversityinformatics.amnh.org/open_source/pdc/documentation.php
 */
class SimplifyDouglasPeucker implements SimplifyInterface
{
    protected float $tolerance;

    /**
     * @param  float  $tolerance  the perpendicular distance threshold in meters
     */
    public function __construct(float $tolerance)
    {
        $this->tolerance = $tolerance;
    }

    /**
     * @throws RuntimeException
     */
    public function simplify(Polyline $polyline): Polyline
    {
        $result = $this->simplifyGeometry($polyline);

        if (!($result instanceof Polyline)) {
            throw new RuntimeException('Result is no Polyline', 9737647468);
        }

        return $result;
    }

    /**
     * This method is a workaround to allow simplifying polygons too. It'll be
     * merged with `simplify()` in the next major release.
     */
    public function simplifyGeometry(GeometryInterface $geometry): GeometryInterface
    {
        if (!($geometry instanceof Polyline) && !($geometry instanceof Polygon)) {
            return $geometry;
        }

        $counterPoints = $geometry->getNumberOfPoints();

        if ($geometry instanceof Polygon) {
            if ($counterPoints <= 3) {
                return clone $geometry;
            }
            $result = new Polygon();
        } else {
            if ($counterPoints < 3) {
                return clone $geometry;
            }
            $result = new Polyline();
        }

        $simplifiedLine = $this->douglasPeucker($geometry->getPoints());

        $result->addPoints($simplifiedLine);

        return $result;
    }

    /**
     * @param  Coordinate[]  $line
     * @return  Coordinate[]
     */
    protected function douglasPeucker(array $line): array
    {
        $distanceMax = 0;
        $index = 0;

        $lineSize = count($line);

        $pdCalc = new PerpendicularDistance();

        for ($i = 1; $i <= $lineSize - 2; $i++) {
            $distance = $pdCalc->getPerpendicularDistance($line[$i], new Line($line[0], $line[$lineSize - 1]));

            if ($distance > $distanceMax) {
                $index = $i;
                $distanceMax = $distance;
            }
        }

        if ($distanceMax > $this->tolerance) {
            $lineSplitFirst = array_slice($line, 0, $index + 1);
            $lineSplitSecond = array_slice($line, $index, $lineSize - $index);

            $resultsSplit1 = count($lineSplitFirst) > 2
                ? $this->douglasPeucker($lineSplitFirst)
                : $lineSplitFirst;

            $resultsSplit2 = count($lineSplitSecond) > 2
                ? $this->douglasPeucker($lineSplitSecond)
                : $lineSplitSecond;

            array_pop($resultsSplit1);

            return array_merge($resultsSplit1, $resultsSplit2);
        }

        return [$line[0], $line[$lineSize - 1]];
    }
}
