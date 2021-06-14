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
    public function getException(): Exception;

    /**
     * @param Exception $exception
     */
    public function setException(Exception $exception);

    /**
     * @return bool
     * @deprecated
     */
    public function success(): bool;

    /**
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * @param PDOStatement $pdoStatement
     */
    public function setPdoStatement(PDOStatement $pdoStatement);

    /**
     * @param array $bindings
     */
    public function setBindings(array $bindings);

    /**
     * @return null|array
     */
    public function getBindings(): ?array;

    /**
     * @return null|PDOStatement
     */
    public function getPdoStatement(): ?PDOStatement;

    /**
     * @param string $input
     */
    public function setSqlType(string $input);

    /**
     * @return string
     */
    public function getSqlType(): string;

    /**
     * @return mixed
     */
    public function getLastInsertId();

    /**
     * @param mixed $input
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
    public function getFirstRow(): array;

    /**
     * @Note Same as PDOStatement::rowCount(), the number of rows affected by INSERT, UPDATE, DELETE, but not SELECT
     * @return int
     */
    public function getRowsAffected(): int;

    /**
     * @Note gets the number of records in from the select statement. Do not use with SQL_CALC_FOUND_ROWS
     * @return int
     */
    public function getRecordCount(): int;

    /**
     * @Note Use with SQL_CALC_FOUND_ROWS to get the total number of rows found in search that uses LIMIT
     * @param int $input
     */
    public function setRowsFound(int $input);

    /**
     * @Note Use with SQL_CALC_FOUND_ROWS to get the total number of rows found in search that uses LIMIT
     * @return int
     */
    public function getRowsFound(): int;

    /**
     * @return bool|mixed
     */
    public function nextSet();

    /**
     * @param ?string $col indicates using a column's value to create an associated array output
     * @param bool $sub_arrays
     * @return array
     */
    public function getOutput(string $col = null, bool $sub_arrays = false): array;

    /**
     * @return string
     */
    public function getSql(): string;

    /**
     * @return string|string[]
     */
    public function getSqlPopulated();
}
