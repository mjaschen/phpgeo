<?php
/**
 * Coordinate Implementation
 *
 * PHP version 5.3
 *
 * @category  Location
 * @author    Marcus T. Jaschen <mjaschen@gmail.com>
 * @copyright 2013 r03.org
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      http://r03.org/
 */

namespace Location;

use Location\Ellipsoid,
    Location\Distance,
    Location\Distance\DistanceInterface,
    Location\Formatter\Coordinate\FormatterInterface;

/**
 * Coordinate Implementation
 *
 * @category Location
 * @author   Marcus T. Jaschen <mjaschen@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://r03.org/
 */
class Coordinate
{
    /**
     * @var float
     */
    protected $lat;

    /**
     * @var float
     */
    protected $lng;

    /**
     * @var Ellipsoid
     */
    protected $ellipsoid;

    /**
     * @param float     $lat       -90.0 .. +90.0
     * @param float     $lng       -180.0 .. +180.0
     * @param Ellipsoid $ellipsoid if omitted, WGS-84 is used
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($lat, $lng, Ellipsoid $ellipsoid = null)
    {
        if (! $this->isValidLatitude($lat)) {
            throw new \InvalidArgumentException("Latitude value must be numeric -90.0 .. +90.0");
        }

        if (! $this->isValidLongitude($lng)) {
            throw new \InvalidArgumentException("Latitude value must be numeric -180.0 .. +180.0");
        }

        $this->lat = doubleval($lat);
        $this->lng = doubleval($lng);

        if ($ellipsoid !== null) {
            $this->ellipsoid = $ellipsoid;
        } else {
            $this->ellipsoid = Ellipsoid::createDefault();
        }
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @return Ellipsoid
     */
    public function getEllipsoid()
    {
        return $this->ellipsoid;
    }

    /**
     * Calculates the distance between the given coordinate
     * and this coordinate.
     *
     * @param Coordinate        $coordinate
     * @param DistanceInterface $calculator instance of distance calculation class
     *
     * @return float
     */
    public function getDistance(Coordinate $coordinate, DistanceInterface $calculator)
    {
        return $calculator->getDistance($this, $coordinate);
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
     * Validates latitude
     *
     * @param mixed $latitude
     *
     * @return bool
     */
    protected function isValidLatitude($latitude)
    {
        if (! is_numeric($latitude)) {
            return false;
        }

        if ($latitude < - 90.0 || $latitude > 90.0) {
            return false;
        }

        return true;
    }

    /**
     * Validates longitude
     *
     * @param mixed $longitude
     *
     * @return bool
     */
    protected function isValidLongitude($longitude)
    {
        if (! is_numeric($longitude)) {
            return false;
        }

        if ($longitude < - 180.0 || $longitude > 180.0) {
            return false;
        }

        return true;
    }
}