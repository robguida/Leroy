<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/4/18
 * Time: 12:34 AM
 */

namespace LeroysBackside\LeType;


class LeIntMed extends LeNumber implements LeNumericInterface
{
    /**
     * @return float|int
     */
    public static function getMin()
    {
        return -8388608;
    }

    /**
     * @return float|int
     */
    public static function getMax()
    {
        return 8388607;
    }

    /**
     * @param float|int $value
     * @return LeNumericInterface|LeTypeInterface|LeNumber|LeIntMed
     */
    public static function set($value)
    {
        return parent::init($value, self::getMin(), self::getMax(), true, 0);
    }

    /**
     * @param float|int $value
     * @return false|LeNumber|LeNumericInterface|LeTypeInterface|LeIntMed
     */
    public static function verify($value)
    {
        return parent::validate($value, self::getMin(), self::getMax(), true, 0);
    }
}
