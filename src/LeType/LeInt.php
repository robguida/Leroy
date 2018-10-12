<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/4/18
 * Time: 12:34 AM
 */

namespace LeroysBackside\LeType;

use Exception;

class LeInt extends LeNumber
{
    /**
     * @return float|int
     */
    public function getMin()
    {
        return -2147483648;
    }

    /**
     * @return float|int
     */
    public function getMax()
    {
        return 2147483647;
    }

    /**
     * @param mixed $value
     * @return LeNumber
     */
    public static function set($value)
    {
        $output = new LeInt($value);
    }
}
