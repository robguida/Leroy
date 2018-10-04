<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 6/3/18
 * Time: 6:06 PM
 */
define('DEVENV', 'dev' == $_SERVER['USER']);
if (DEVENV) {
    error_reporting(E_ALL);
    require_once dirname(__FILE__, 2) . '/vendor/autoload.php';
}
