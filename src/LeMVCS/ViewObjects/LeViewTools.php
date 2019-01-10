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
     * @param string $relative_file_path file name and path relative to the web root
     * @param string $full_file_path file name and path relative to the drive
     * @param string $key
     * @return string
     */
    public function getVersionedUrl($relative_file_path, $full_file_path, $key = 'r')
    {
        $mod_time = filemtime($full_file_path);
        $qs_joiner = (false === strpos($relative_file_path, '?')) ? '?' : '&';
        $output = "{$relative_file_path}{$qs_joiner}{$key}={$mod_time}";
        return $output;
    }

    /**
     * @param string $relative_file_path file name and path relative to the web root
     * @param string $full_file_path file name and path relative to the drive
     * @param string $key
     */
    public function addVersionToUrl(& $relative_file_path, $full_file_path, $key = 'r')
    {
        $relative_file_path = self::getVersionedUrl($relative_file_path, $full_file_path, $key);
    }
}
