<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 6/3/18
 * Time: 6:06 PM
 */
define('DEVENV', in_array($_SERVER['SERVER_NAME'], ['leroysbackside.development.com', 'dev.robguida.com']));
if (DEVENV) {
    error_reporting(E_ALL);
    session_start();
    session_regenerate_id(true);
    date_default_timezone_set('America/New_York');
    ini_set('include_path', __DIR__);
}

require_once dirname(__FILE__, 2) . '/vendor/autoload.php';
