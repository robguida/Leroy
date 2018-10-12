<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 5/14/18
 * Time: 8:28 PM
 */

namespace LeroysBackside\LeType;

use Exception;
use InvalidArgumentException;

class LeNumber implements LeTypeInterface
{
    /** @var integer|float */
    private $value;
    /** @var boolean */
    private $signed;
    /** @var integer */
    private $precision;

    /**
     * LeNumber constructor.
     * @param integer|float $value
     * @param LeUnIntSmall|null $min
     * @param LeUnIntSmall|null $max
     * @param bool|null $signed
     * @param LeUnIntSmall|null $precision
     * @param bool $validate
     */
    protected function __construct(
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
            $this->precision = filter_var($this->value, FILTER_VALIDATE_INT) ? 0 : self::detectPrecision($value);
            $this->value = $value;
        }
        $this->signed = !is_null($signed) ? $signed : (0 > $this->value);

        $this->value = !is_null($precision) ? round($value, $precision) : $value;
    }

    /**
     * @param integer|float $value
     * @param LeUnIntSmall|null $min
     * @param LeUnIntSmall|null $max
     * @param bool|null $signed
     * @param LeUnIntSmall|null $precision
     * @return LeNumber
     */
    public static function init($value, $min = null, $max = null, $signed = null, $precision = null)
    {
        $output = new LeNumber($value, $min, $max, $signed, $precision);
        return $output;
    }

    /**
     * @param integer|float $value
     * @param LeUnIntSmall|null $min
     * @param LeUnIntSmall|null $max
     * @param bool|null $signed
     * @param LeUnIntSmall|null $precision
     * @return bool|LeNumber
     */
    public static function validate($value, $min = null, $max = null, $signed = null, $precision = null)
    {
        try {
            $output = new LeNumber($value, $min, $max, $signed, $precision, true);
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
}
