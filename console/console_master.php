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
require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

$action = '';
array_shift($argv);
if ($argv) {
    foreach ($argv as $arg) {
        if ('help' == $arg) {
            die(help());
        }
        list($key, $val) = explode('=', $arg);
        $$key = $val;
    }
}
