<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/4/18
 * Time: 12:34 AM
 */

namespace LeroysBackside\LeType;


class LeIntMed extends LeNumber implements LeTypeInterface
{
    /**
     * @return float|int
     */
    public function getMin()
    {
        return -8388608;
    }

    /**
     * @return float|int
     */
    public function getMax()
    {
        return 8388607;
    }

    /**
     * @param float|int $value
     * @return LeNumber|LeTypeInterface|LeInt
     */
    public function set($value)
    {
        return parent::init($value, 0, self::getMin(), self::getMax());
    }

    /**
     * @param float|int $value
     * @return bool|LeNumber
     */
    public function verify($value)
    {
        return parent::validate($value, 0, self::getMin(), self::getMax());
    }
}
