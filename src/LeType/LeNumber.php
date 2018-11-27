<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 5/14/18
 * Time: 8:28 PM
 */

namespace Leroy\LeType;

use Exception;
use InvalidArgumentException;

/**
 * Class LeNumber
 * @package Leroy\LeType
 */
class LeNumber implements LeTypeInterface
{
    /** @var integer|float */
    private $value;
    /** @var boolean */
    private $signed;
    /** @var integer */
    private $precision;

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
     * LeNumber constructor.
     * @param integer|float $value
     * @param LeUnIntSmall|null $min
     * @param LeUnIntSmall|null $max
     * @param bool|null $signed
     * @param LeUnIntSmall|null $precision
     * @param bool $validate
     */
    private function __construct(
        $value,
        $min = null,
        $max = null,
        $signed = null,
        $precision = null,
        $validate = false
    ) {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException("{$value} is not numeric");
        }

        if (!is_null($min) && $min > $value) {
            throw new InvalidArgumentException("{$value} cannot be less than {$min}");
        }

        if (!is_null($max) && $max < $value) {
            throw new InvalidArgumentException("{$value} cannot be greater than {$max}");
        }

        if (false === $signed && 0 > $value) {
            throw new InvalidArgumentException("{$value} is not a positive number");
        }

        /* Only test against precision when the value is being validated.
            Otherwise, the value will be rounded to the precision amount */
        if ($validate && !is_null($precision)) {
            if (0 == $precision && false === filter_var($value, FILTER_VALIDATE_INT)) {
                throw new InvalidArgumentException("{$value} is not a valid integer");
            } elseif (0 < $precision) {
                if (false === filter_var($value, FILTER_VALIDATE_FLOAT)) {
                    throw new InvalidArgumentException("{$value} is not a valid float");
                } elseif ($precision != self::detectPrecision($value)) {
                    throw new InvalidArgumentException("{$value} does not match precision of {$precision}");
                }
            }
        }

        if (!is_null($precision)) {
            $this->precision = $precision;
            $this->value = round($value, $precision);
        } else {
            $this->precision = filter_var($value, FILTER_VALIDATE_INT) ? 0 : self::detectPrecision($value);
            $this->value = $value;
        }
        $this->signed = !is_null($signed) ? $signed : (0 > $this->value);
    }

    /**
     * @param integer|float $value
     * @param LeUnIntSmall|null $min
     * @param LeUnIntSmall|null $max
     * @param bool|null $signed
     * @param LeUnIntSmall|null $precision
     * @return LeTypeInterface
     */
    public static function init($value, $min = null, $max = null, $signed = null, $precision = null)
    {
        $class = get_called_class();
        if (is_null($min)) {
            $min = self::getMin();
        }
        if (is_null($max)) {
            $max = self::getMax();
        }
        $output = new $class($value, $min, $max, $signed, $precision);
        return $output;
    }

    /**
     * @param integer|float $value
     * @param LeUnIntSmall|null $min
     * @param LeUnIntSmall|null $max
     * @param bool|null $signed
     * @param LeUnIntSmall|null $precision
     * @return bool|LeTypeInterface
     */
    public static function validate($value, $min = null, $max = null, $signed = null, $precision = null)
    {
        try {
            $class = get_called_class();
            if (is_null($min)) {
                $min = self::getMin();
            }
            if (is_null($max)) {
                $max = self::getMax();
            }
            $output = new $class($value, $min, $max, $signed, $precision, true);
        } catch (Exception $e) {
            $output = false;
        }
        return $output;
    }

    /**
     * @return float|int|boolean|string
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isSigned()
    {
        return $this->signed;
    }

    /**
     * @return int
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * @param LeUnIntSmall|float $value
     * @return int
     */
    protected function detectPrecision($value)
    {
        return (int)strlen(substr(strrchr($value, "."), 1));
    }
}
