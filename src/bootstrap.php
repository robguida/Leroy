<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 6/3/18
 * Time: 6:06 PM
 */
error_reporting(E_ALL);
session_start([
    'use_strict_mode' => true,
    'use_only_cookies' => true,
    'cookie_httponly' => true,
    'session_switch' => true,
    'cookie_lifetime' => 54000, // 15 minutes
]);
session_regenerate_id(true);
date_default_timezone_set('America/New_York');
spl_autoload_register('autoLoader');
ini_set('include_path', __DIR__);

/**
 * @param $class
 * @throws Exception
 */
function autoLoader($class)
{
    static $autoLoader;
    if (is_null($autoLoader)) {
        $autoLoader = [];
    }
    if (!in_array($class, $autoLoader)) {
        $autoLoader[] = $class;
        $path = dirname(__FILE__);
        $dirs = explode("\\", $class);
        $className = end($dirs) . '.php';
        array_pop($dirs);

        if (!empty($dirs)) {
            $path .= '/' . implode('/', $dirs);
            $path = implode('/', array_unique(explode('/', $path))) . '/';
        }

        $fullFileName = "{$path}{$className}";
        if (file_exists("$fullFileName")) {
            require($fullFileName);
        } else {
            throw new Exception("The namespace for '{$class}' resolves to " .
                "{$fullFileName}', which does not exist!");
        }
    }
}
