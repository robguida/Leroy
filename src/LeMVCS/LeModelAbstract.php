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
    /** @var array Stores data from the dbase and is NEVER modified. It is used to determine what was changed. */
    private $original = [];
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
    protected function setData(string $key, $val)
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
        if (is_null($this->data)
            && $this->dbResult instanceof LeDbResultInterface
            && LeDbService::SQL_TYPE_READ == $this->dbResult->getSqlType()
        ) {
            /* Using getFirstRow() since this is a model, and there is only one row, which will be
                in position 0 (zero) of the LeDbResult::output. Using getOutput() will provide the
                entire record set, and in this case there is only 1 record. */
            $this->loadData($this->dbResult->getFirstRow());
        }
        return $this->data;
    }

    /**
     * @return array
     */
    public function getOriginalData()
    {
        return $this->original;
    }

    /**
     * @return array
     */
    public function getChanges()
    {
        $output = [];
        foreach ($this->original as $key => $original_val) {
            /* Some keys can be removed from data, for instance when a column
                uses CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP. So, the
                original data may still have the value, but since it is not
                being altered - it is not in the data array - we just ignore it. */
            if (isset($this->data[$key]) && $new_val = $this->data[$key]) {
                if (0 !== strcmp($original_val, $new_val)) {
                    $output[$key] = ['new' => $new_val, 'original' => $original_val];
                }
            }
        }
        return $output;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function removeKeyFromData(string $key)
    {
        $output = false;
        if (isset($this->data[$key])) {
            unset($this->data[$key]);
            $output = true;
        }
        return $output;
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
    protected function getData(string $key)
    {
        if (!array_key_exists($key, $this->data)) {
            if (array_key_exists($key, $this->schema)) {
                $this->setData($key, null);
            } else {
                throw new InvalidArgumentException("{$key} is not define in LeModelAbstract::schema");
            }
        }
        $output = null;
        $data = $this->getAllData();
        if (array_key_exists($key, $data)) {
            $output = $data[$key];
        }
        return $output;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasData(string $key)
    {
        $output = false;
        if (array_key_exists($key, $this->data)) {
            $output = !empty($this->data[$key]);
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
     * @return bool|LeModelAbstract
     * @throws Exception
     */
    public static function initWithId($id, LeDbService $db = null)
    {
        /**
         * @var LeModelAbstract $model
         */
        $output = false;
        $class = get_called_class();
        $model = new $class($db);
        if ($model->loadFromId($id)) {
            $output = $model;
        }
        return $output;
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
     * @return array|null
     */
    public function getErrors()
    {
        $output = null;
        $error_info = $this->dbResult->getErrorInfo();
        $error_code = $this->dbResult->getErrorCode();
        if ($error_info || $error_code) {
            $output = ['error' => $error_info, 'code' => $error_code,];
        }
        return $output;
    }

    /**
     * @return string
     */
    public function getErrorString()
    {
        $output = '';
        if ($errors = $this->getErrors()) {
            $errors_formatted = [];
            foreach ($errors as $key => $val) {
                $errors_formatted[] = "{$key}: {$val}";
            }
            $output = implode('; ', $errors_formatted);
        }
        return $output;
    }

    /**
     * @return Exception
     */
    public function getException()
    {
        return $this->dbResult->getException();
    }
    //</editor-fold>

    //<editor-fold desc="Core DB Functions">
    /**
     * @param boolean $on_duplicate_update
     * @return bool|int
     * @throws Exception
     */
    public function save(bool $on_duplicate_update = false)
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
    protected function update(string $on_duplicate_key_clause)
    {
        /* create the columns and build the on_dupes array while we are at it. */
        list($cols, $bindings) = array_values($this->getColsAndBindings());
        $i = 0;
        foreach ($cols as $col) {
            $cols[$i++] = "`{$col}` = ?";
        }
        $bindings[] = $this->getId();
         /* create and run the sql */
        $sql = "UPDATE `{$this->getTableName()}` SET " .
            implode(', ', $cols) . " WHERE `{$this->getPrimaryKey()}` = ? " .
            "{$on_duplicate_key_clause};";
        $this->dbResult = $this->getDb()->execute($sql, $bindings);
        if ($this->dbResult->isSuccess()) {
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
    protected function insert(string $on_duplicate_key_clause)
    {
        $db = $this->getDb();
        list($cols, $bindings) = array_values($this->getColsAndBindings());
        $needles = array_fill(0, count($cols), '?');
        $sql = "INSERT INTO `{$this->getTableName()}` (`" . implode('`, `', $cols) . "`) " .
            "VALUES (" . implode(', ', $needles) . ") " .
            "{$on_duplicate_key_clause};";
        $this->dbResult = $db->execute($sql, $bindings);
        if ($this->dbResult->isSuccess()) {
            if (!$on_duplicate_key_clause) {
                /* When this is a strict insert, we can load the record */
                $output = $this->dbResult->getLastInsertId();
                $this->loadFromId($output, true);
            } else {
                /* When on duplicate key update is used there is no last insert id. We
                    select on the values used in the insert and then get the pkey and return that */
                $sql = "SELECT * FROM `{$this->getTableName()}` WHERE " . implode(' = ? AND ', $cols) . ' = ?;';
                $result = $db->execute($sql, $bindings);
                if ($result->isSuccess()) {
                    if (1 <= $result->getRecordCount()) {
                        $this->loadData($result->getFirstRow());
                        $output = $this->getId();
                    } else {
                        error_log('>>>>>>>>>>>>>>>>>>>>>>>>>>>> On duplicate key cannot find record');
                        error_log( __FILE__ . ' ' . __LINE__ . ' $result->getRecordCount(): ' . $result->getRecordCount());
                        error_log(__FILE__ . ' ' . __LINE__ . ' $result->getFirstRow(): ' . print_r($result->getFirstRow(), true));
                        error_log( __FILE__ . ' ' . __LINE__ . ' $this->primary_key: ' . $this->primary_key);
                        error_log( __FILE__ . ' ' . __LINE__ . ' last insert id: ' . $result->getLastInsertId());
                        error_log(__FILE__ . ' ' . __LINE__ . ' $bindings: ' . print_r($bindings, true));
                        error_log( __FILE__ . ' ' . __LINE__ . ' $sql: ' . $sql);
                        error_log('>>>>>>>>>>>>>>>>>>>>>>>>>>>> On duplicate key cannot find record - EOF');
                    }
                } else {
                    $output = false;
                }
            }
        } else {
            /* $this->dbLoadResult will be available to the calling class to get errors */
            $output = false;
        }
        return $output;
    }

    /**
     * @param stirng|int $id
     * @param bool $use_prime
     * @return bool
     * @throws Exception
     */
    protected function loadFromId($id, bool $use_prime = false)
    {
        $output = false;
        $sql = "SELECT * FROM {$this->table_name} WHERE {$this->primary_key} = ?";
        $this->dbResult = $this->db->execute($sql, [$id], false, $use_prime);
        if ($this->dbResult->isSuccess() && $data = $this->dbResult->getFirstRow()) {
            $output = true;
            $this->loadData($data);
        }
        return $output;
    }

    /**
     * @param array $input
     * @throws Exception
     * @todo loadData() and populateBindings() needs to use a common validation function that uses the types
     */
    protected function loadData(array $input)
    {
        $this->original = $input;
        foreach ($this->schema as $column => $attrs) {
            $callback_set = null;
            $value = null;
            if (isset($input[$column])) {
                $value = $input[$column];
                if ('string' == $attrs['type'] && !empty($attrs['length']) && is_int($attrs['length'])) {
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
     * @todo update all model schemas so default is always a key in the array, and remove the isset() functions
     */
    private function getColsAndBindings()
    {
        $output = ['cols' => [], 'bindings' => []];
        foreach ($this->data as $column => $value) {
            /* Primary keys will not be in the schema, so we skip this part. */
            if (isset($this->schema[$column]) && $attrs = $this->schema[$column]) {
                if (isset($attrs['callback_get']) && $call_back = $attrs['callback_get']) {
                    $value = $this->$call_back();
                } elseif ('enum' == $attrs['type'] && !in_array($value, $attrs['length'])) {
                    throw new InvalidArgumentException("\"{$value}\" is not a valid enum values for `{$column}`.");
                } elseif ((isset($attrs['default']) && false !== strpos($attrs['default'], 'CURRENT_TIMESTAMP')) ||
                    (isset($attrs['extended']) && false !== strpos($attrs['extended'], 'CURRENT_TIMESTAMP'))
                ) {
                    /* if the table has a default for the current timestamp, then let the table set the value */
                    continue;
                } elseif (empty($value) && isset($attrs['default'])) {
                    /* When there is no value, then set the value to the default value */
                    $value = $attrs['default'];
                } elseif ('NULL' == strtoupper($value) && is_null($attrs['default'])) {
                    $value = null;
                }
            }
            $output['cols'][] = $column;
            $output['bindings'][] = $value;
        }
        return $output;
    }
    //</editor-fold>
}
