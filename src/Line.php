<?php

declare(strict_types=1);

namespace Location;

use Location\Bearing\BearingInterface;
use Location\Distance\DistanceInterface;
use Location\Utility\Cartesian;
use RuntimeException;

/**
 * Line Implementation
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class Line implements GeometryInterface
{
    use GetBoundsTrait;

    /**
     * @var Coordinate
     */
    protected $point1;

    /**
     * @var Coordinate
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
     * @param Coordinate $point1
     *
     * @return void
     *
     * @deprecated
     */
    public function setPoint1(Coordinate $point1)
    {
        $this->point1 = $point1;
    }

    /**
     * @return Coordinate
     */
    public function getPoint1(): Coordinate
    {
        return $this->point1;
    }

    /**
     * @param Coordinate $point2
     *
     * @return void
     *
     * @deprecated
     */
    public function setPoint2(Coordinate $point2)
    {
        $this->point2 = $point2;
    }

    /**
     * @return Coordinate
     */
    public function getPoint2(): Coordinate
    {
        return $this->point2;
    }

    /**
     * Returns an array containing the two points.
     *
     * @return array<Coordinate>
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
     * @param BearingInterface $bearingCalculator
     *
     * @return float
     */
    public function getBearing(BearingInterface $bearingCalculator): float
    {
        return $bearingCalculator->calculateBearing($this->point1, $this->point2);
    }

    /**
     * @param BearingInterface $bearingCalculator
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
        return new self($this->point2, $this->point1);
    }

    /**
     * Get the midpoint of a Line segment
     *
     * @see http://www.movable-type.co.uk/scripts/latlong.html#midpoint
     *
     * @return Coordinate
     */
    public function getMidpoint(): Coordinate
    {
        $lat1 = deg2rad($this->point1->getLat());
        $lng1 = deg2rad($this->point1->getLng());
        $lat2 = deg2rad($this->point2->getLat());
        $lng2 = deg2rad($this->point2->getLng());
        $deltaLng = $lng2 - $lng1;

        $A = new Cartesian(cos($lat1), 0, sin($lat1));
        $B = new Cartesian(cos($lat2) * cos($deltaLng), cos($lat2) * sin($deltaLng), sin($lat2));
        $C = $A->add($B);

        $latMid = atan2($C->getZ(), sqrt($C->getX() ** 2 + $C->getY() ** 2));
        $lngMid = $lng1 + atan2($C->getY(), $C->getX());

        return new Coordinate(rad2deg($latMid), rad2deg($lngMid));
    }

    /**
     * Returns the point which is located on the line at the
     * given fraction (starting at point 1).
     *
     * @see http://www.movable-type.co.uk/scripts/latlong.html#intermediate-point
     * @see http://www.edwilliams.org/avform.htm#Intermediate
     *
     * @param float $fraction 0.0 ... 1.0 (smaller or larger values work too)
     *
     * @return Coordinate
     *
     * @throws RuntimeException
     */
    public function getIntermediatePoint(float $fraction): Coordinate
    {
        $lat1 = deg2rad($this->point1->getLat());
        $lng1 = deg2rad($this->point1->getLng());
        $lat2 = deg2rad($this->point2->getLat());
        $lng2 = deg2rad($this->point2->getLng());
        $deltaLat = $lat2 - $lat1;
        $deltaLng = $lng2 - $lng1;

        if ($lat1 + $lat2 == 0.0 && abs($lng1 - $lng2) == M_PI) {
            throw new RuntimeException(
                'Start and end points are antipodes, route is therefore undefined.',
                5382449689
            );
        }

        $a = sin($deltaLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($deltaLng / 2) ** 2;
        $delta = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $A = sin((1 - $fraction) * $delta) / sin($delta);
        $B = sin($fraction * $delta) / sin($delta);

        $x = $A * cos($lat1) * cos($lng1) + $B * cos($lat2) * cos($lng2);
        $y = $A * cos($lat1) * sin($lng1) + $B * cos($lat2) * sin($lng2);
        $z = $A * sin($lat1) + $B * sin($lat2);

        $lat = atan2($z, sqrt($x ** 2 + $y ** 2));
        $lng = atan2($y, $x);

        return new Coordinate(rad2deg($lat), rad2deg($lng));
    }
}
