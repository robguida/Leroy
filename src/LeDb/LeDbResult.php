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

    /** @var array */
    private $output;

    /** @var integer */
    private $rows_found;
    /** @var string */
    private $sql_type;

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
     * @return bool
     */
    public function success()
    {
        return ($this->getPdoStatement() instanceof PDOStatement);
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
     * @Note Same as PDOStatement::rowCount(), the number of rows affected by INSERT, UPDATE, DELETE, but not SELECT
     * @return int
     */
    public function getRowsAffected()
    {
        $output = null;
        if ($this->pdoStatement instanceof PDOStatement) {
            $output = $this->getPdoStatement()->rowCount();
        }
        return $output;
    }
    /**
     * @Note Use with SQL_CALC_FOUND_ROWS to get the total number of rows found in search that uses LIMIT
     * @param int $input
     */
    public function setRowsFound($input)
    {
        $this->rows_found = (int)$input;
    }

    /**
     * @Note gets Use with SQL_CALC_FOUND_ROWS to get the total number of rows found in search that uses LIMIT
     * @return int
     */
    public function getRowsFound()
    {
        return $this->rows_found;
    }

    /**
     * @Note gets the number of records in from the select statement. Do not use with SQL_CALC_FOUND_ROWS
     * @return int
     */
    public function getRowCount()
    {
        return count($this->fetchAssoc());
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
        if (is_null($this->output)) {
            $this->output = [];
            /* The code can only fetch on a select */
            if ($this->pdoStatement instanceof PDOStatement && 'slave' == $this->getSqlType()) {
                $this->output = $this->getPdoStatement()->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        return $this->output;
    }

    /**
     * @return mixed
     */
    public function getFirstValue()
    {
        $output = $this->getFirstRow();
        if (0 < count($output)) {
            $output = current($output);
        }
        return $output;
    }

    /**
     * @return array
     */
    public function getFirstRow()
    {
        $output = $this->fetchAssoc();
        if (0 < count($output)) {
            $output = current($output);
        }
        return $output;
    }

    /**
     * @return string
     */
    public function getSql()
    {
        $output = $this->getPdoStatement()->queryString;
        return $output;
    }

    /**
     * @param string $input
     */
    public function setSqlType($input)
    {
        $this->sql_type = $input;
    }

    /**
     * @return string
     */
    public function getSqlType()
    {
        return $this->sql_type;
    }
}
