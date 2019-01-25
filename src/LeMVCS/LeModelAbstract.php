<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 11:45 AM
 */

namespace Leroy\LeMVCS;

use Exception;
use InvalidArgumentException;
use Leroy\LeDb\LeDbResultInterface;
use Leroy\LeDb\LeDbService;

abstract class LeModelAbstract
{
    /** @var string|integer */
    private $id;
    /** @var string */
    protected $primary_key;
    /** @var string */
    protected $table_name = '';
    /** @var array */
    protected $schema = [];
    /** @var boolean */
    private $schema_has_callbacks = false;
    /** @var array Stores data to save or use for getters - the data for the model. Key => value pair */
    private $data = [];
    /** @var LeDbService */
    protected $db;
    /** @var LeDbResultInterface */
    protected $dbResult;


    //<editor-fold desc="Getters/Setters">
    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|string $id
     * @throws Exception
     */
    private function setId($id)
    {
        if (!empty($this->id) && $this->id != $id) {
            $class = get_called_class();
            $exception = "{$class}::{$this->getPrimaryKey()} was instantiated with {$this->id}. " .
                "Attempt to overwrite id using {$id}.";
            throw new Exception($exception);
        }
        // do validation???
        $this->id = $id;
    }

    /**
     * @param string $key
     * @param mixed $val
     */
    protected function setData($key, $val)
    {
        if (!array_key_exists($key, $this->schema)) {
            throw new InvalidArgumentException("{$key} is not define in LeModelAbstract:schema");
        }
        // could perform validation here
        $this->data[$key] = $val;
    }

    /**
     * @return array
     */
    public function getAllData()
    {
        if ($this->dbResult instanceof LeDbResultInterface
            && LeDbService::SQL_TYPE_READ == $this->dbResult->getSqlType()
        ) {
            /* Using getFirstRow() since this is a model, and there is only one row, which will be
                in position 0 (zero) of the LeDbResult::output. Using getOutput() will provide the
                entire record set, and in this case there is only 1 record. */
            $this->data = $this->dbResult->getFirstRow();
        }
        return $this->data;
    }

    /**
     * @param LeDbService $db
     */
    public function setDb(LeDbService $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $key
     * @return mixed
     */
    protected function getData($key)
    {
        if (!array_key_exists($key, $this->data)) {
            throw new InvalidArgumentException("{$key} is not define in LeModelAbstract::data");
        }
        $output = null;
        $data = $this->getAllData();
        if (array_key_exists($key, $data)) {
            $output = $data[$key];
        }
        return $output;
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return $this->table_name;
    }

    /**
     * @return string
     */
    protected function getPrimaryKey()
    {
        return $this->primary_key;
    }

    /**
     * @return array
     */
    protected function getSchema()
    {
        return $this->schema;
    }

    protected function doesSchemaUseCallBacks()
    {
        return $this->schema_has_callbacks;
    }

    protected function schemaUsesCallBacks()
    {
        $this->schema_has_callbacks = true;
    }

    /**
     * LeModelAbstract constructor.
     * @param LeDbService|null $db
     */
    protected function __construct(LeDbService $db = null)
    {
        $this->setPrimaryKey();
        $this->setSchema();
        $this->setTableName();
        $this->setDb($db);
    }

    /**
     * @return LeDbService
     */
    protected function getDb()
    {
        return $this->db;
    }
    //</editor-fold>

    abstract protected function setPrimaryKey();
    abstract protected function setSchema();
    abstract protected function setTableName();

    //<editor-fold desc="Initializing Functions">

    /**
     * @param int|string $id
     * @param LeDbService|null $db
     * @return LeModelAbstract|null
     * @throws Exception
     */
    public static function initWithId($id, LeDbService $db = null)
    {
        /**
         * @var LeModelAbstract $model
         */
        $class = get_called_class();
        $model = new $class($db);
        $model->loadFromId($id);
        return $model;
    }

    /**
     * @param array $input
     * @param LeDbService|null $db
     * @return LeModelAbstract|null
     *
     * @throws Exception
     */
    public static function initWithArray(array $input, LeDbService $db = null)
    {
        /**
         * @var LeModelAbstract $model
         * @var LeDbResultInterface $result
         */
        $class = get_called_class();
        $model = new $class($db);
        $model->loadData($input);
        return $model;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return [
            'error' => $this->dbResult->getErrorInfo(),
            'code' => $this->dbResult->getErrorCode(),
            'exception' => $this->dbResult->getException()->getMessage()
        ];
    }

    /**
     * @return string
     */
    public function getErrorString()
    {
        $output = '';
        $error = [];
        if ($this->dbResult->getErrorInfo()) {
            $error[] = "error: {$this->dbResult->getErrorInfo()}";
        }
        if ($this->dbResult->getErrorCode()) {
            $error[] = "code: {$this->dbResult->getErrorCode()}";
        }
        if ($this->dbResult->getException()) {
            $error[] = "exception: {$this->dbResult->getException()->getMessage()()}";
        }
        if ($error) {
            $output = implode('; ', $error);
        }
        return $output;
    }
    //</editor-fold>

    //<editor-fold desc="Core DB Functions">
    /**
     * @param boolean $on_duplicate_update
     * @return bool|int
     * @throws Exception
     */
    public function save($on_duplicate_update = false)
    {

        /* Create the on duplicate key clause? */
        $on_duplicate_key_clause = '';
        if ($on_duplicate_update) {
            $on_duplicate_key_clause = $this->getDuplicateKeyClause();
        }

        if (is_null($this->getId())) {
            $output = $this->insert($on_duplicate_key_clause);
        } else {
            $output = $this->update($on_duplicate_key_clause);
        }
        return $output;
    }

    /**
     * @param string $on_duplicate_key_clause
     * @return int|false
     */
    protected function update($on_duplicate_key_clause)
    {
        /* create the columns and build the on_dupes array while we are at it. */
        $cols = [];
        foreach (array_keys($this->data) as $col) {
            $cols[] = "`{$col}` = ?";
        }
        /* populate the bindings */
        $bindings = $this->populateBindings();
        $bindings[] = $this->getId();
         /* create and run the sql */
        $sql = "UPDATE `{$this->getTableName()}` SET " .
            implode(', ', $cols) . " WHERE `{$this->getPrimaryKey()}` = ? " .
            "{$on_duplicate_key_clause};";
        $this->dbResult = $this->getDb()->execute($sql, $bindings);
        if ($this->dbResult->success()) {
            $output = $this->dbResult->getRowsAffected();
        } else {
            $output = false;
        }
        return $output;
    }

    /**
     * @param string $on_duplicate_key_clause
     * @return int|false
     * @throws Exception
     */
    protected function insert($on_duplicate_key_clause)
    {
        $cols = array_keys($this->data);
        $needles = array_fill(0, count($cols), '?');
        $bindings = $this->populateBindings();
        $sql = "INSERT INTO `{$this->getTableName()}` (`" . implode('`, `', $cols) . "`) " .
            "VALUES (" . implode(', ', $needles) . ") " .
            "{$on_duplicate_key_clause};";
        $this->dbResult = $this->getDb()->execute($sql, $bindings);
        if ($this->dbResult->success()) {
            /* $this->dbLoadResult will be overwritten when loading the object */
            $output = $this->dbResult->getLastInsertId();
            $this->loadFromId($output, true);
        } else {
            /* $this->dbLoadResult will be available to the calling class to get errors */
            $output = false;
        }
        return $output;
    }

    /**
     * @param $id
     * @param bool $use_prime
     * @throws Exception
     */
    protected function loadFromId($id, $use_prime = false)
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE {$this->primary_key} = ?";
        $this->dbResult = $this->db->execute($sql, [$id], false, $use_prime);
        if ($this->dbResult->success()) {
            $this->loadData($this->dbResult->getFirstRow());
        }
    }

    /**
     * @param array $input
     * @throws Exception
     * @todo loadData() and populateBindings() needs to use a common validation function that uses the types
     */
    protected function loadData(array $input)
    {
        foreach ($this->schema as $column => $attrs) {
            if (isset($input[$column])) {
                $value = $input[$column];
                if (!empty($attrs['length']) && 'string' == $attrs['type']) {
                    $value = substr($value, 0, $attrs['length']);
                } elseif ('enum' == $attrs['type'] && !in_array($value, $attrs['length'])) {
                    throw new Exception("'{$value}' is not a valid enum value for `{$column}`;");
                }
            } else {
                $value = null;
            }
            if (isset($attrs['callback_set']) && $callback_set = $attrs['callback_set']) {
                $this->$callback_set($value);
            } else {
                $this->data[$column] = $value;
            }
        }
        if (array_key_exists($this->getPrimaryKey(), $input)) {
            /* include the primary key in the data */
            $primary_key = $this->getPrimaryKey();
            $this->data[$primary_key] = $input[$primary_key];
            $this->setId($input[$primary_key]);
        }
    }

    /**
     * @return string
     */
    private function getDuplicateKeyClause()
    {
        $output = '';
        if ($this->data) {
            $on_dupes = [];
            foreach (array_keys($this->data) as $col) {
                $on_dupes[] = "`{$col}` = VALUES(`{$col}`)";
            }
            $output = ' ON DUPLICATE KEY UPDATE ' . implode(', ', $on_dupes);
        }
        return $output;
    }

    /**
     * @return array
     * @todo loadData() and populateBindings() needs to use a common validation function that uses the types
     */
    private function populateBindings()
    {
        $bindings = [];
        if ($this->doesSchemaUseCallBacks()) {
            foreach ($this->data as $column => $value) {
                $attrs = $this->schema[$column];
                if (isset($attrs['callback_get']) && $call_back = $attrs['callback_get']) {
                    $value = $this->$call_back($value);
                }
                $bindings[] = $value;
            }
        } else {
            $bindings = array_values($this->data);
        }
        return $bindings;
    }
    //</editor-fold>
}
