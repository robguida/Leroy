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
class LeDbResult implements LeDbResultInterface
{
    /** @var Exception */
    private $exception;

    /** @var PDOStatement */
    private $pdoStatement;

    /** @var integer */
    private $last_insert_id;

    /** @var mixed */
    private $error_code;

    /** @var string */
    private $error_info;

    /**
     * @param null|PDOStatement $pdoStatement
     */
    public function setPdoStatement(PDOStatement $pdoStatement)
    {
        $this->pdoStatement = $pdoStatement;
    }

    /**
     * @return null|PDOStatement
     */
    public function getPdoStatement()
    {
        return $this->pdoStatement;
    }

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

    /**
     * @return integer
     */
    public function getLastInsertId()
    {
        return $this->last_insert_id;
    }

    /**
     * @param integer $input
     */
    public function setLastInsertId($input)
    {
        $this->last_insert_id = (int)$input;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * @param mixed $input
     */
    public function setErrorCode($input)
    {
        $this->error_code = $input;
    }

    /**
     * @return mixed
     */
    public function getErrorInfo()
    {
        return $this->error_info;
    }

    /**
     * @param mixed $input
     */
    public function setErrorInfo($input)
    {
        $this->error_info = $input;
    }

    /**
     * @return int
     */
    public function getRowCount()
    {
        $output = null;
        if ($this->pdoStatement instanceof PDOStatement) {
            $output = $this->getPdoStatement()->rowCount();
        }
        return $output;
    }

    /**
     * @return integer
     */
    public function getTotalRecordsFound()
    {
        $output = null;
        if ($this->pdoStatement instanceof PDOStatement) {
            $output = (int)$this->getPdoStatement()->query('SELECT FOUND_ROWS()')->fetchColumn();
        }
        return $output;
    }

    /**
     * @return bool
     */
    public function nextSet()
    {
        $output = null;
        if ($this->pdoStatement instanceof PDOStatement) {
            $output = $this->getPdoStatement()->nextRowset();
        }
        return $output;
    }

    /**
     * @return array
     */
    public function fetchAssoc()
    {
        $output = null;
        if ($this->pdoStatement instanceof PDOStatement) {
            $output = $this->getPdoStatement()->fetchAll(PDO::FETCH_ASSOC);
        }
        return $output;
    }
}
