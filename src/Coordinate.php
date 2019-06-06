<?php
declare(strict_types=1);

namespace Location;

use Location\Distance\DistanceInterface;
use Location\Formatter\Coordinate\FormatterInterface;

/**
 * Coordinate Implementation
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class Coordinate implements GeometryInterface
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
     * @param float $lat -90.0 .. +90.0
     * @param float $lng -180.0 .. +180.0
     * @param Ellipsoid $ellipsoid if omitted, WGS-84 is used
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(float $lat, float $lng, Ellipsoid $ellipsoid = null)
    {
        if (! $this->isValidLatitude($lat)) {
            throw new \InvalidArgumentException('Latitude value must be numeric -90.0 .. +90.0 (given: ' . $lat . ')');
        }

        if (! $this->isValidLongitude($lng)) {
            throw new \InvalidArgumentException(
                'Longitude value must be numeric -180.0 .. +180.0 (given: ' . $lng . ')'
            );
        }

        $this->lat = $lat;
        $this->lng = $lng;

        if ($ellipsoid instanceof Ellipsoid) {
            $this->ellipsoid = $ellipsoid;

            return;
        }

        $this->ellipsoid = Ellipsoid::createDefault();
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLng(): float
    {
        return $this->lng;
    }

    /**
     * Returns an array containing the point
     *
     * @return Coordinate[]
     */
    public function getPoints(): array
    {
        return [$this];
    }

    /**
     * @return Ellipsoid
     */
    public function getEllipsoid(): Ellipsoid
    {
        return $this->ellipsoid;
    }

    /**
     * Calculates the distance between the given coordinate
     * and this coordinate.
     *
     * @param Coordinate $coordinate
     * @param DistanceInterface $calculator instance of distance calculation class
     *
     * @return float
     */
    public function getDistance(Coordinate $coordinate, DistanceInterface $calculator): float
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
     * @param float $latitude
     *
     * @return bool
     */
    protected function isValidLatitude(float $latitude): bool
    {
        return $this->isNumericInBounds($latitude, -90.0, 90.0);
    }

    /**
     * Validates longitude
     *
     * @param float $longitude
     *
     * @return bool
     */
    protected function isValidLongitude(float $longitude): bool
    {
        return $this->isNumericInBounds($longitude, -180.0, 180.0);
    }

    /**
     * Checks if the given value is (1) numeric, and (2) between lower
     * and upper bounds (including the bounds values).
     *
     * @param float $value
     * @param float $lower
     * @param float $upper
     *
     * @return bool
     */
    protected function isNumericInBounds(float $value, float $lower, float $upper): bool
    {
        return !($value < $lower || $value > $upper);
    }
    
    /**
     * Returns the request in latitude and longitude strintring
     *
     * @return string
     */    
    public function __toString() {
        $string = $this->lat . "," . $this->lng;
        
        return $string;
    }    
}
