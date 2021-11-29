<?php

declare(strict_types=1);

namespace Location;

/**
 * Ellipsoid
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class Ellipsoid
{
    /**
     * @var string
     */
    protected $name;

    /**
     * The semi-major axis
     *
     * @var float
     */
    protected $a;

    /**
     * The Inverse Flattening (1/f)
     *
     * @var float
     */
    protected $f;

    /**
     * Some often used ellipsoids
     *
     * @var array<string, array{name: string, a: float, f: float}>
     */
    protected static $configs = [
        'WGS-84' => [
            'name' => 'World Geodetic System 1984',
            'a'    => 6378137.0,
            'f'    => 298.257223563,
        ],
        'GRS-80' => [
            'name' => 'Geodetic Reference System 1980',
            'a'    => 6378137.0,
            'f'    => 298.257222100,
        ],
    ];

    /**
     * @param string $name
     * @param float $a
     * @param float $f
     */
    public function __construct(string $name, float $a, float $f)
    {
        $this->name = $name;
        $this->a    = $a;
        $this->f    = $f;
    }

    /**
     * @param string $name
     *
     * @return Ellipsoid
     */
    public static function createDefault(string $name = 'WGS-84'): Ellipsoid
    {
        return static::createFromArray(static::$configs[$name]);
    }

    /**
     * @param array $config
     *
     * @return Ellipsoid
     */
    public static function createFromArray(array $config): Ellipsoid
    {
        return new self($config['name'], $config['a'], $config['f']);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getA(): float
    {
        return $this->a;
    }

    /**
     * Calculation of the semi-minor axis
     *
     * @return float
     */
    public function getB(): float
    {
        return $this->a * (1 - 1 / $this->f);
    }

    /**
     * @return float
     */
    public function getF(): float
    {
        return $this->f;
    }

    /**
     * Calculates the arithmetic mean radius
     *
     * @see http://home.online.no/~sigurdhu/WGS84_Eng.html
     *
     * @return float
     */
    public function getArithmeticMeanRadius(): float
    {
        return $this->a * (1 - 1 / $this->f / 3);
    }
}
