<?php
/**
 * Line Implementation
 *
 * PHP version 5
 *
 * @category  Location
 * @author    Marcus Jaschen <mjaschen@gmail.com>
 * @copyright 1999-2013 MTB-News.de
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      http://www.mtb-news.de/
 */

namespace Location;

use Location\Distance\DistanceInterface;

/**
 * Line Implementation
 *
 * @category Location
 * @author   Marcus Jaschen <mjaschen@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://www.mtb-news.de/
 */
class Line
{
    /**
     * @var \Location\Coordinate
     */
    protected $coordinate1;

    /**
     * @var \Location\Coordinate
     */
    protected $coordinate2;

    /**
     * @param Coordinate $coordinate1
     * @param Coordinate $coordinate2
     */
    public function __construct(Coordinate $coordinate1, Coordinate $coordinate2)
    {
        $this->coordinate1 = $coordinate1;
        $this->coordinate2 = $coordinate2;
    }

    /**
     * @param \Location\Coordinate $coordinate1
     */
    public function setCoordinate1($coordinate1)
    {
        $this->coordinate1 = $coordinate1;
    }

    /**
     * @return \Location\Coordinate
     */
    public function getCoordinate1()
    {
        return $this->coordinate1;
    }

    /**
     * @param \Location\Coordinate $coordinate2
     */
    public function setCoordinate2($coordinate2)
    {
        $this->coordinate2 = $coordinate2;
    }

    /**
     * @return \Location\Coordinate
     */
    public function getCoordinate2()
    {
        return $this->coordinate2;
    }

    /**
     * Calculates the length of the line (distance between the two
     * coordinates).
     *
     * @param DistanceInterface $calculator instance of distance calculation class
     *
     * @return float
     */
    public function getLength(DistanceInterface $calculator)
    {
        return $calculator->getDistance($this->coordinate1, $this->coordinate2);
    }
}