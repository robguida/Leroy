<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/4/18
 * Time: 12:34 AM
 */

namespace Leroy\LeType;

class LeInt extends LeNumber implements LeNumericInterface
{
    /**
     * @return float|int
     */
    public static function getMin()
    {
        return -2147483648;
    }

    /**
     * @return float|int
     */
    public static function getMax()
    {
        return 2147483647;
    }
    /**
     * @param mixed $value
     * @return LeNumericInterface|LeTypeInterface|LeNumber|LeInt
     */
    public static function set($value)
    {
        return parent::init($value, self::getMin(), self::getMax(), true, 0);
    }

    /**
     * @param mixed $value
     * @return false|LeNumber|LeNumericInterface|LeTypeInterface|LeInt
     */
    public static function verify($value)
    {
        return parent::validate($value, self::getMin(), self::getMax(), true, 0);
    }
}
