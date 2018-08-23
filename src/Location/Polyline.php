<?php
declare(strict_types=1);

/**
 * Polyline Implementation
 *
 * PHP version 7
 *
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/mjaschen/phpgeo
 */

namespace Location;

use Location\Distance\DistanceInterface;
use Location\Formatter\Polyline\FormatterInterface;

/**
 * Polyline Implementation
 *
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  https://opensource.org/licenses/MIT
 * @link     https://github.com/mjaschen/phpgeo
 */
class Polyline implements GeometryInterface
{
    /**
     * @var array
     */
    protected $points = [];

    /**
     * @param Coordinate $point
     *
     * @return void
     */
    public function addPoint(Coordinate $point)
    {
        $this->points[] = $point;
    }

  /**
   * Add single point
   *
   * @param Coordinate $pointToAdd
   */
    public function addSinglePoint(Coordinate $pointToAdd) {
      foreach($this->points as $point){
        /* @var $point Coordinate */
        if(($point->getLat() == $pointToAdd->getLat()) && ($point->getLng() == $pointToAdd->getLng())) {
          return;
        }
      }

      $this->points[] = $pointToAdd;
    }

    /**
     * @return array
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * @return int
     */
    public function getNumberOfPoints(): int
    {
        return count($this->points);
    }

    /**
     * @param FormatterInterface $formatter
     *
     * @return mixed
     */
    public function format(FormatterInterface $formatter)
    {
        return $formatter->format($this);
    }

    /**
     * @return array
     */
    public function getSegments(): array
    {
        $length   = count($this->points);
        $segments = [];

        if ($length <= 1) {
            return $segments;
        }

        for ($i = 1; $i < $length; $i++) {
            $segments[] = new Line($this->points[$i - 1], $this->points[$i]);
        }

        return $segments;
    }

    /**
     * Calculates the length of the polyline.
     *
     * @param DistanceInterface $calculator instance of distance calculation class
     *
     * @return float
     */
    public function getLength(DistanceInterface $calculator): float
    {
        $distance = 0.0;

        if (count($this->points) <= 1) {
            return $distance;
        }

        foreach ($this->getSegments() as $segment) {
            $distance += $segment->getLength($calculator);
        }

        return $distance;
    }

    /**
     * Create a new polyline with reversed order of points, i. e. reversed
     * polyline direction.
     *
     * @return Polyline
     */
    public function getReverse(): Polyline
    {
        $reversed = new static();

        foreach (array_reverse($this->points) as $point) {
            $reversed->addPoint($point);
        }

        return $reversed;
    }

  /**
   * RGet the middle point of Polyline
   * @return Coordinate
   */
    public function getMiddlePoint(): Coordinate {
      $lat = 0.0;
      $lng = 0.0;
      $numberOfPoints = count($this->points);

      if($numberOfPoints < 1) {
        return null;
      }

      foreach($this->points as $point){
        /* @var $point Coordinate */
        $lat += $point->getLat();
        $lng += $point->getLng();
      }

      $lat /= $numberOfPoints;
      $lng /= $numberOfPoints;

      return new Coordinate($lat, $lng);
    }
}
