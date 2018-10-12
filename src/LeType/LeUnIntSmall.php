<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/4/18
 * Time: 12:34 AM
 */

namespace LeroysBackside\LeType;


class LeUnIntSmall extends LeNumber implements LeTypeInterface
{
    /**
     * @return float|int
     */
    public function getMin()
    {
        return 0;
    }

    /**
     * @return float|int
     */
    public static function getMax()
    {
        return 65535;
    }

    /**
     * @param float|int $value
     * @return LeNumber|LeTypeInterface|LeInt
     */
    public static function set($value)
    {
        return parent::init($value, 0, self::getMin(), self::getMax());
    }

    /**
     * @param float|int $value
     * @return bool|LeNumber
     */
    public static function verify($value)
    {
        return parent::validate($value, 0, self::getMin(), self::getMax());
    }
}
