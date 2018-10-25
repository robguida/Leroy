<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 9/27/2018
 * Time: 12:20 AM
 *
 * This file should be included in every console file created in Leroy, just after all
 *      variables are defined.
 */

$action = '';

if ($args = array_shift($argv)) {
    foreach ($args as $arg) {
        list($key, $val) = explode('=', $arg);
        $$key = $val;
    }
}
