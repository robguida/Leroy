<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/17/18
 * Time: 11:35 PM
 */

namespace LeroysBackside\LeDb;

use Exception;
use PDO;
use PDOStatement;

/**
 * Class LeDbResut
 * @package LeroysBackside\LeDb
 *
 * This object is passed back with every query done in LeDbService
 */
class LeDbResult
{
    /** @var Exception */
    private $exception = null;

    /**
     * @return Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     */
    public function setException($exception)
    {
        $this->exception = $exception;
    }
}
