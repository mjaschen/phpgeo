<?php

declare(strict_types=1);

namespace Location\Processor\Polyline;

use Location\Line;
use Location\Polyline;
use Location\Utility\PerpendicularDistance;

/**
 * /**
 * Simplify Polyline with the Douglas-Peucker-Algorithm
 *
 * The Algorithm is described here:
 * http://en.wikipedia.org/wiki/Ramer%E2%80%93Douglas%E2%80%93Peucker_algorithm
 *
 * The formula for the Perpendicular Distance is described here:
 * http://biodiversityinformatics.amnh.org/open_source/pdc/documentation.php
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class SimplifyDouglasPeucker implements SimplifyInterface
{
    /**
     * @var float
     */
    protected $tolerance;

    /**
     * @param float $tolerance the perpendicular distance threshold in meters
     */
    public function __construct(float $tolerance)
    {
        $this->tolerance = $tolerance;
    }

    /**
     * @param Polyline $polyline
     *
     * @return Polyline
     */
    public function simplify(Polyline $polyline): Polyline
    {
        $resultPolyline = new Polyline();
        $simplifiedLine = $this->douglasPeucker($polyline->getPoints());

        foreach ($simplifiedLine as $point) {
            $resultPolyline->addPoint($point);
        }

        return $resultPolyline;
    }

    /**
     * @param array $line
     *
     * @return array
     */
    protected function douglasPeucker(array $line): array
    {
        $distanceMax = 0;
        $index = 0;

        $lineSize = count($line);

        $pdCalc = new PerpendicularDistance();

        for ($i = 1; $i <= ($lineSize - 2); $i++) {
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
