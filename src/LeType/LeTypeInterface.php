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
     */
    public function getMin();

    /**
     * @return float|int
     */
    public function getMax();

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
