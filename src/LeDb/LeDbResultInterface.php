<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 9/25/2018
 * Time: 11:13 PM
 */

namespace LeroysBackside\LeDb;

use Exception;

interface LeDbResultInterface
{
    /**
     * @return Exception
     */
    public function getException();

    /**
     * @param Exception $exception
     */
    public function setException($exception);
}
