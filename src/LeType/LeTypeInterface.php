<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/5/18
 * Time: 1:20 PM
 */

namespace LeroysBackside\LeType;

interface LeTypeInterface
{
    /**
     * @return float|int
     * @note MySql BigInt do not convert to PHP. MySql smallest value for a signed BigInt
     *          is -1 * pow(2, 63), with ends up being an exponential value.
     *          PHP's min value is -9223372036854775807
     *          So, use MySql BigInt values with caution.
     * @link http://php.net/manual/en/language.types.integer.php
     */
    public static function getMin();

    /**
     * @return float|int
     * @note MySql BigInt do not convert to PHP. MySql largest value for a signed BigInt
     *          is pow(2, 63), with ends up being an exponential value.
     *          PHP's max value is 9223372036854775807
     *          So, use MySql BigInt values with caution.
     * @link http://php.net/manual/en/language.types.integer.php
     */
    public static function getMax();

    /**
     * @return float|int|boolean|string
     */
    public function get();

    /**
     * @param integer|float $value
     * @param LeUnIntSmall|null $min
     * @param LeUnIntSmall|null $max
     * @param bool|null $signed
     * @param LeUnIntSmall|null $precision
     * @return LeTypeInterface
     */
    public static function init($value, $min = null, $max = null, $signed = null, $precision = null);

    /**
     * @param integer|float $value
     * @param LeUnIntSmall|null $min
     * @param LeUnIntSmall|null $max
     * @param bool|null $signed
     * @param LeUnIntSmall|null $precision
     * @return bool|LeTypeInterface
     */
    public static function validate($value, $min = null, $max = null, $signed = null, $precision = null);
}
