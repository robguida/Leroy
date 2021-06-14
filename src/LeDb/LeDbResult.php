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
    private Exception $exception;

    /** @var PDOStatement */
    private PDOStatement $pdoStatement;

    /** @var integer */
    private int $last_insert_id;

    /** @var mixed */
    private $error_code;

    /** @var string */
    private string $error_info;

    /** @var array */
    private array $data;

    /** @var array */
    private array $output;

    /** @var integer */
    private int $rows_found;

    /** @var string */
    private string $sql_type;

    /** @var array */
    private array $bindings;

    public function __construct()
    {
        $this->output = [];
        $this->data = [];
    }

    /**
     * @param PDOStatement $pdoStatement
     */
    public function setPdoStatement(PDOStatement $pdoStatement)
    {
        $this->pdoStatement = $pdoStatement;
    }

    /**
     * @return null|PDOStatement
     */
    public function getPdoStatement(): ?PDOStatement
    {
        return $this->pdoStatement;
    }

    /**
     * @return Exception
     */
    public function getException(): Exception
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

    /**
     * @return array|null
     */
    public function getBindings(): ?array
    {
        return $this->bindings;
    }

    /**
     * @return bool
     * @deprecated
     */
    public function success(): bool
    {
        return $this->isSuccess();
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return ($this->getPdoStatement() instanceof PDOStatement);
    }

    /**
     * @return integer
     */
    public function getLastInsertId(): int
    {
        return $this->last_insert_id;
    }

    /**
     * @param mixed $input
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
     * @return string
     */
    public function getErrorInfo(): string
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
    public function getRowsAffected(): int
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
    public function setRowsFound(int $input)
    {
        $this->rows_found = (int)$input;
    }

    /**
     * @Note gets Use with SQL_CALC_FOUND_ROWS to get the total number of rows found in search that uses LIMIT
     * @return int
     */
    public function getRowsFound(): int
    {
        return $this->rows_found;
    }

    /**
     * @Note gets the number of records in from the select statement. Do not use with SQL_CALC_FOUND_ROWS
     * @return int
     */
    public function getRecordCount(): int
    {
        $output = 0;
        /* If there is data in LeDbResult::output, then we can get the count. Otherwise, return 0. */
        if ($data = $this->getData()) {
            $output = count($data);
        }
        return $output;
    }

    /**
     * @return bool|mixed
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
     * @param bool $sub_arrays
     * @return array
     */
    public function getOutputDep($col = null, bool $sub_arrays = false): array
    {
        if (is_null($this->output)) {
            $output = $this->output = [];
            /* The code can only fetch on a select */
            if ($this->pdoStatement instanceof PDOStatement && LeDbService::SQL_TYPE_READ == $this->getSqlType()) {
                $output = $this->getPdoStatement()->fetchAll(PDO::FETCH_ASSOC);
            }
            if (!is_null($col) && !empty($output)) {
                if ($sub_arrays) {
                    foreach ($output as $row) {
                        $this->output[$row[$col]][] = $row;
                    }
                } else {
                    foreach ($output as $row) {
                        $this->output[$row[$col]] = $row;
                    }
                }
            } else {
                $this->output = $output;
            }
        }
        return $this->output;
    }

    private function getData(): array
    {
        if (is_null($this->data)) {
            $this->data = [];
            /* The code can only fetch on a select */
            if ($this->pdoStatement instanceof PDOStatement && LeDbService::SQL_TYPE_READ == $this->getSqlType()) {
                $this->data = $this->getPdoStatement()->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        return $this->data;
    }

    /**
     * @param null $col indicates using a column's value to create an associated array output
     * @param bool $sub_arrays
     * @return array
     */
    public function getOutput($col = null, bool $sub_arrays = false): array
    {
        $data = $this->getData();
        $consolidate = !is_null($col) && !empty($data);
        $key = $consolidate ? "{$col}_" . (int)$sub_arrays : 'default';
        if (! array_key_exists($key, $this->output)) {
            if ($consolidate) {
                $this->output[$key] = [];
                if ($sub_arrays) {
                    foreach ($this->data as $row) {
                        $this->output[$key][$row[$col]][] = $row;
                    }
                } else {
                    foreach ($this->data as $row) {
                        $this->output[$key][$row[$col]] = $row;
                    }
                }
            } else {
                $this->output[$key] = $this->data;
            }
        }
        return $this->output[$key];
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
     * @return array
     */
    public function getFirstRow(): array
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
    public function getSql(): string
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
    public function setSqlType(string $input)
    {
        $this->sql_type = $input;
    }

    /**
     * @return string
     */
    public function getSqlType(): string
    {
        return $this->sql_type;
    }
}
