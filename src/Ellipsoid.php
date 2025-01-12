<?php

declare(strict_types=1);

namespace Location;

class Ellipsoid
{
    /**
     * Some often used ellipsoids
     *
     * @var array<string, array{name: string, a: float, f: float}>
     */
    protected static $configs = [
        'WGS-84' => [
            'name' => 'World Geodetic System 1984',
            'a' => 6378137.0,
            'f' => 298.257223563,
        ],
        'GRS-80' => [
            'name' => 'Geodetic Reference System 1980',
            'a' => 6378137.0,
            'f' => 298.257222100,
        ],
    ];

    /**
     * @param  string  $name
     * @param  float  $a  The semi-major axis
     * @param  float  $f  The Inverse Flattening (1/f)
     */
    public function __construct(public readonly string $name, public readonly float $a, public readonly float $f)
    {
    }

    public static function createDefault(string $name = 'WGS-84'): Ellipsoid
    {
        return static::createFromArray(static::$configs[$name]);
    }

    /**
     * @param  array{name: string, a: float, f: float}  $config
     */
    public static function createFromArray(array $config): Ellipsoid
    {
        return new self($config['name'], $config['a'], $config['f']);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getA(): float
    {
        return $this->a;
    }

    /**
     * Calculation of the semi-minor axis
     */
    public function getB(): float
    {
        return $this->a * (1 - 1 / $this->f);
    }

    public function getF(): float
    {
        return $this->f;
    }

    /**
     * Calculates the arithmetic mean radius
     *
     * @see http://home.online.no/~sigurdhu/WGS84_Eng.html
     */
    public function getArithmeticMeanRadius(): float
    {
        return $this->a * (1 - 1 / $this->f / 3);
    }
}
