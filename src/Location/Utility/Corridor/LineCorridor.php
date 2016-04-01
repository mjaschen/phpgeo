<?php

namespace Location\Utility\Corridor;

use Location\Bearing\BearingInterface;
use Location\Line;
use Location\Polygon;

class LineCorridor
{
    /**
     * @var float distance between line and the corridor border, in meters
     */
    private $distance;

    /**
     * @var \Location\Bearing\BearingInterface
     */
    private $bearingCalculator;

    /**
     * LineCorridor constructor.
     *
     * @param float $distance
     */
    public function __construct($distance, BearingInterface $bearingCalculator)
    {
        if ($distance <= 0.0) {
            throw new \InvalidArgumentException("distance must be greater than 0");
        }

        $this->distance          = $distance;
        $this->bearingCalculator = $bearingCalculator;
    }

    public function createCorridor(Line $line)
    {
        throw new \RuntimeException("Method not implemented yet.");

        $corridor = new Polygon();

        $bearingForward = $line->getBearing($this->bearingCalculator);
        $bearingReverse = $line->getReverse()->getBearing($this->bearingCalculator);

        $corridor->addPoint($this->bearingCalculator->calculateDestination($line->getPoint1(), fmod($bearingForward + 135, 360), $this->distance));
        $corridor->addPoint($this->bearingCalculator->calculateDestination($line->getPoint1(), fmod($bearingForward - 135, 360), $this->distance));
        $corridor->addPoint($this->bearingCalculator->calculateDestination($line->getPoint2(), fmod($bearingReverse - 135, 360), $this->distance));
        $corridor->addPoint($this->bearingCalculator->calculateDestination($line->getPoint2(), fmod($bearingReverse + 135, 360), $this->distance));

        return $corridor;
    }
}
