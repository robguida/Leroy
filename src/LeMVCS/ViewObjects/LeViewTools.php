<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 11/4/2018
 * Time: 4:41 PM
 */

namespace Leroy\LeMVCS\ViewObjects;

class LeViewTools
{
    /**
     * @param string $file full file path and file name
     * @param string $key
     * @return string
     */
    public static function getVersionedUrl($file, $key = 'r')
    {
        $mod_time = filemtime($file);
        $qs_joiner = (false === strpos($file, '?')) ? '?' : '&';
        $output = "{$file}{$qs_joiner}{$key}={$mod_time}";
        return $output;
    }

    public static function addVersionToUrl(& $file, $key = 'r')
    {
        $file = self::getVersionedUrl($file, $key);
    }
}
