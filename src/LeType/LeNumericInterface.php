<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/12/2018
 * Time: 12:39 AM
 */

namespace Leroy\LeType;


interface LeNumericInterface
{
    /**
     * @param mixed $value
     * @return LeTypeInterface
     */
    public static function set($value);

    /**
     * @param mixed $value
     * @return LeTypeInterface
     */
    public static function verify($value);

}