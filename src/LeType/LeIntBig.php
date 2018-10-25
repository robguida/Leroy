<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/4/18
 * Time: 12:34 AM
 */

namespace Leroy\LeType;

class LeIntBig extends LeNumber implements LeNumericInterface
{
    /**
     * @return float|int
     * @note MySql BigInt do not convert to PHP. MySql lowest value for a signed BigInt
     *          is -1 * pow(2, 63), with ends up being an exponential value.
     *          PHP's min value is -9223372036854775807
     *          So, use MySql BigInt values with caution.
     * @link http://php.net/manual/en/language.types.integer.php
     */
    public static function getMin()
    {
        return -9223372036854775807;
    }

    /**
     * @return float|int
     * @note MySql BigInt do not convert to PHP. MySql largest value for a signed BigInt
     *          is pow(2, 63), with ends up being an exponential value.
     *          PHP's max value is 9223372036854775807
     *          So, use MySql BigInt values with caution.
     * @link http://php.net/manual/en/language.types.integer.php
     */
    public static function getMax()
    {
        return 9223372036854775807;
    }

    /**
     * @param mixed $value
     * @return LeNumericInterface|LeTypeInterface|LeNumber|LeIntBig
     */
    public static function set($value)
    {
        return parent::init($value, self::getMin(), self::getMax(), true, 0);
    }

    /**
     * @param mixed $value
     * @return false|LeNumber|LeNumericInterface|LeTypeInterface|LeIntBig
     */
    public static function verify($value)
    {
        return parent::validate($value, self::getMin(), self::getMax(), true, 0);
    }

}
