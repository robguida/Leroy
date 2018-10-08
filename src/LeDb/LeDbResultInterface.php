<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 9/25/2018
 * Time: 11:13 PM
 */

namespace LeroysBackside\LeDb;

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
    public function setException($exception);

    /**
     * @param null|PDOStatement $pdoStatement
     */
    public function setPdoStatement(PDOStatement $pdoStatement);

    /**
     * @return null|PDOStatement
     */
    public function getPdoStatement();

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
     * @return int
     */
    public function getRowCount();

    /**
     * @return integer
     */
    public function getTotalRecordsFound();
    /**
     * @return bool
     */
    public function nextSet();

    /**
     * @return array
     */
    public function fetchAssoc();

    /**
     * @return string
     */
    public function getSql();
}
