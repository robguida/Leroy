<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/4/18
 * Time: 12:34 AM
 */

namespace LeroysBackside\LeType;


class LeUnIntBig extends LeNumber implements LeNumericInterface
{
    /**
     * @return float|int
     */
    public static function getMin()
    {
        return 0;
    }

    /**
     * @return float|int
     */
    public static function getMax()
    {
        return 9223372036854775807;
    }

    /**
     * @param float|int $value
     * @return LeNumericInterface|LeTypeInterface|LeNumber|LeUnIntBig
     */
    public static function set($value)
    {
        return parent::init($value, self::getMin(), self::getMax(), false, 0);
    }

    /**
     * @param float|int $value
     * @return false|LeNumber|LeNumericInterface|LeTypeInterface|LeUnIntBig
     */
    public static function verify($value)
    {
        return parent::validate($value, self::getMin(), self::getMax(), false, 0);
    }
}
