<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 9/25/2018
 * Time: 11:13 PM
 */

namespace Leroy\LeDb;

use Exception;
use PDOStatement;

interface LeDbResultInterface
{
    /**
     * @return Exception
     */
    public function getException();

    /**
     * @param Exception $exception
     */
    public function setException(Exception $exception);

    /**
     * @return bool
     */
    public function success();

    /**
     * @param null|PDOStatement $pdoStatement
     */
    public function setPdoStatement(PDOStatement $pdoStatement);

    /**
     * @return null|PDOStatement
     */
    public function getPdoStatement();

    /**
     * @param string $input
     */
    public function setSqlType($input);

    /**
     * @return string
     */
    public function getSqlType();

    /**
     * @return integer
     */
    public function getLastInsertId();

    /**
     * @param integer $input
     */
    public function setLastInsertId($input);

    /**
     * @return mixed
     */
    public function getErrorCode();

    /**
     * @param mixed $input
     */
    public function setErrorCode($input);

    /**
     * @return mixed
     */
    public function getErrorInfo();

    /**
     * @param mixed $input
     */
    public function setErrorInfo($input);

    /**
     * @return mixed
     */
    public function getFirstValue();

    /**
     * @return array
     */
    public function getFirstRow();

    /**
     * @Note Same as PDOStatement::rowCount(), the number of rows affected by INSERT, UPDATE, DELETE, but not SELECT
     * @return int
     */
    public function getRowsAffected();

    /**
     * @Note gets the number of records in from the select statement. Do not use with SQL_CALC_FOUND_ROWS
     * @return int
     */
    public function getRecordCount();

    /**
     * @Note Use with SQL_CALC_FOUND_ROWS to get the total number of rows found in search that uses LIMIT
     * @param int $input
     */
    public function setRowsFound($input);

    /**
     * @Note Use with SQL_CALC_FOUND_ROWS to get the total number of rows found in search that uses LIMIT
     * @return int
     */
    public function getRowsFound();

    /**
     * @return bool
     */
    public function nextSet();

    /**
     * @return array
     */
    public function getOutput();

    /**
     * @return string
     */
    public function getSql();
}
