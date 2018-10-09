<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 6/3/18
 * Time: 6:06 PM
 */

/* The code is running in the dev environment when LeroysBackside is not being accessed from the vendors folder */
define('DEVENV', false === strpos($_SERVER['SCRIPT_NAME'], '/vendor/robguida/leroysbackside/'));
if (DEVENV) {
    /* Only in the dev environment should this code be run. Since this is designed to be used as a
        dependency for another project, those projects would have their own bootstrap file. */
    error_reporting(E_ALL);
    date_default_timezone_set('America/New_York');
    require_once dirname(__FILE__, 2) . '/vendor/autoload.php';
    define('DBCONFIGFILE1', '/var/www/LeroysBackside/test/test_resources/dev1.robguida.com.json');
    define('DBCONFIGFILE2', '/var/www/LeroysBackside/test/test_resources/dev2.robguida.com.json');
}
