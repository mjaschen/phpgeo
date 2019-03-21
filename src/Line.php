<?php
declare(strict_types=1);

/**
 * Line Implementation
 *
 * PHP version 5
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location;

use Location\Bearing\BearingInterface;
use Location\Distance\DistanceInterface;

/**
 * Line Implementation
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */
class Line implements GeometryInterface
{
    /**
     * @var \Location\Coordinate
     */
    protected $point1;

    /**
     * @var \Location\Coordinate
     */
    protected $point2;

    /**
     * @param Coordinate $point1
     * @param Coordinate $point2
     */
    public function __construct(Coordinate $point1, Coordinate $point2)
    {
        $this->point1 = $point1;
        $this->point2 = $point2;
    }

    /**
     * @param \Location\Coordinate $point1
     *
     * @return void
     */
    public function setPoint1(Coordinate $point1)
    {
        $this->point1 = $point1;
    }

    /**
     * @return \Location\Coordinate
     */
    public function getPoint1(): Coordinate
    {
        return $this->point1;
    }

    /**
     * @param \Location\Coordinate $point2
     *
     * @return void
     */
    public function setPoint2(Coordinate $point2)
    {
        $this->point2 = $point2;
    }

    /**
     * @return \Location\Coordinate
     */
    public function getPoint2(): Coordinate
    {
        return $this->point2;
    }

    /**
     * Returns an array containing the two points.
     *
     * @return array
     */
    public function getPoints(): array
    {
        return [$this->point1, $this->point2];
    }

    /**
     * Calculates the length of the line (distance between the two
     * coordinates).
     *
     * @param DistanceInterface $calculator instance of distance calculation class
     *
     * @return float
     */
    public function getLength(DistanceInterface $calculator): float
    {
        return $calculator->getDistance($this->point1, $this->point2);
    }

    /**
     * @param \Location\Bearing\BearingInterface $bearingCalculator
     *
     * @return float
     */
    public function getBearing(BearingInterface $bearingCalculator): float
    {
        return $bearingCalculator->calculateBearing($this->point1, $this->point2);
    }

    /**
     * @param \Location\Bearing\BearingInterface $bearingCalculator
     *
     * @return float
     */
    public function getFinalBearing(BearingInterface $bearingCalculator): float
    {
        return $bearingCalculator->calculateFinalBearing($this->point1, $this->point2);
    }

    /**
     * Create a new instance with reversed point order, i. e. reversed direction.
     *
     * @return Line
     */
    public function getReverse(): Line
    {
        return new static($this->point2, $this->point1);
    }
}
