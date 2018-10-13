<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/4/18
 * Time: 12:34 AM
 */

namespace LeroysBackside\LeType;


class LeIntTiny extends LeNumber implements LeNumericInterface
{
    /**
     * @return float|int
     */
    public static function getMin()
    {
        return -128;
    }

    /**
     * @return float|int
     */
    public static function getMax()
    {
        return 127;
    }

    /**
     * @param float|int $value
     * @return LeNumericInterface|LeTypeInterface|LeNumber|LeIntTiny
     */
    public static function set($value)
    {
        return parent::init($value, self::getMin(), self::getMax(), true, 0);
    }

    /**
     * @param float|int $value
     * @return false|LeNumber|LeNumericInterface|LeTypeInterface|LeIntTiny
     */
    public static function verify($value)
    {
        return parent::validate($value, self::getMin(), self::getMax(), true, 0);
    }
}
