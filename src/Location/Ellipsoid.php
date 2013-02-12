<?php
/**
 * Ellipsoid
 *
 * PHP version 5.3
 *
 * @category  Location
 * @package   Location
 * @author    Marcus T. Jaschen <mjaschen@gmail.com>
 * @copyright 2013 r03.org
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      http://www.mtb-news.de/
 */

namespace Location;

/**
 * Ellipsoid
 *
 * @category Location
 * @author   Marcus T. Jaschen <mjaschen@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://www.mtb-news.de/
 */
class Ellipsoid
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $a;

    /**
     * @var float
     */
    protected $b;

    /**
     * the 1/f value (not f!)
     *
     * @var float
     */
    protected $f;

    /**
     * Some often used ellipsoids
     *
     * @var array
     */
    protected static $configs = array(
        'WGS-84' => array(
            'name' => 'WGS-84',
            'a'    => 6378137.0,
            'b'    => 6356752.3142,
            'f'    => 298.257223563,
        ),
    );

    /**
     * @param $name
     * @param $a
     * @param $b
     * @param $f
     */
    public function __construct($name, $a, $b, $f)
    {
        $this->name = $name;
        $this->a    = $a;
        $this->b    = $b;
        $this->f    = $f;
    }

    /**
     * @param string $name
     *
     * @return Ellipsoid
     */
    public static function createDefault($name = 'WGS-84')
    {
        return self::createFromArray(self::$configs[$name]);
    }

    /**
     * @param $config
     *
     * @return Ellipsoid
     */
    public static function createFromArray($config)
    {
        return new self($config['name'], $config['a'], $config['b'], $config['f']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * @return float
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * @return float
     */
    public function getF()
    {
        return $this->f;
    }
}