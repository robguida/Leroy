<?php
/**
 * Created by PhpStorm.
 * User: robgu
 * Date: 1/25/2020
 * Time: 6:52 AM
 */

namespace Leroy\LeApi;

use Exception;

/**
 * Class LeApiExceptionModel
 * @package Leroy\LeApi
 *
 * A safe way to pass Exception back to the source making the call
 */
class LeApiExceptionModel extends Exception
{
    public static function init(Exception $exception)
    {
        $output = new LeApiExceptionModel();
        $output->message = $exception->getMessage();
        $output->file = $exception->getFile();
        $output->line = $exception->getLine();
        $output->code = $exception->getCode();
        return $output;
    }
}