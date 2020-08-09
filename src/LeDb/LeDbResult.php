<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/17/18
 * Time: 11:35 PM
 */

namespace Leroy\LeDb;

use Exception;
use PDO;
use PDOStatement;

/**
 * Class LeDbResult
 * @package Leroy\LeDb
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

    /** @var array */
    private $bindings;

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
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
        $this->setErrorCode($exception->getCode());
        $this->setErrorInfo($exception->getMessage());
    }

    public function setBindings(array $bindings)
    {
        $this->bindings = $bindings;
    }

    public function getBindings()
    {
        return $this->bindings;
    }

    /**
     * @return bool
     * @deprecated
     */
    public function success()
    {
        return $this->isSuccess();
    }

    /**
     * @return bool
     */
    public function isSuccess()
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
    public function getRecordCount()
    {
        $output = 0;
        /* If there is data in LeDbResult::output, then we can get the count. Otherwise, return 0. */
        if ($this->getOutput()) {
            $output = count($this->output);
        }
        return $output;
    }

    /**
     * @return bool
     */
    public function nextSet()
    {
        if (is_null($this->output)) {
            $this->output = [];
        }
        /* The key starts with LeDbResultRowSet_0, and increments with each data set */
        $key = 'LeDbResultRowSet_' . count($this->output);
        if ($this->pdoStatement instanceof PDOStatement) {
            $this->output[$key] = $this->getPdoStatement()->nextRowset();
        }
        return $this->output[$key];
    }

    /**
     * @param null $col indicates using a column's value to create an associated array output
     * @return array
     */
    public function getOutput($col = null)
    {
        if (is_null($this->output)) {
            $output = $this->output = [];
            /* The code can only fetch on a select */
            if ($this->pdoStatement instanceof PDOStatement && LeDbService::SQL_TYPE_READ == $this->getSqlType()) {
                $output = $this->getPdoStatement()->fetchAll(PDO::FETCH_ASSOC);
            }
            if (!is_null($col) && !empty($output)) {
                foreach ($output as $row) {
                    $this->output[$row[$col]] = $row;
                }
            } else {
                $this->output = $output;
            }
        }
        return $this->output;
    }

    /**
     * @return mixed|null
     */
    public function getFirstValue()
    {
        $output = $this->getFirstRow();
        if (!is_null($output) && 0 < count($output)) {
            $output = current($output);
        }
        return $output;
    }

    /**
     * @return array|null
     */
    public function getFirstRow()
    {
        $output = $this->getOutput();
        if (0 < count($output)) {
            $output = current($output);
        } else {
            $output = null;
        }
        return $output;
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return $this->getPdoStatement()->queryString;
    }

    /**
     * @return string|string[]
     */
    public function getSqlPopulated()
    {
        $sql = $this->getSql();
        foreach ($this->bindings as $k => $v) {
            if (!is_numeric($v)) {
                $v = "'{$v}'";
            }
            $sql = str_replace($k, $v, $sql);
        }
        return $sql;
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
