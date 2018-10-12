<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/4/18
 * Time: 12:34 AM
 */

namespace LeroysBackside\LeType;

class LeIntBig extends LeNumber implements LeTypeInterface
{
    /**
     * @return float|int
     */
    public function getMin()
    {
        return -1 * pow(2, 63);
    }

    /**
     * @return float|int
     */
    public function getMax()
    {
        return pow(2, 63) - 1;
    }

    /**
     * @param float|int $value
     * @return LeNumber|LeTypeInterface|LeIntBig
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
