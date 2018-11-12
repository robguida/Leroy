<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 11:45 AM
 */

namespace Leroy\LeMVCS;

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
    private $schema_has_call_backs = false;
    /** @var array */
    private $data = [];
    /** @var LeDbService */
    protected $db;
    /** @var LeDbResultInterface */
    protected $dbResult;


    //<editor-fold desc="Getters/Setters">
    /**
     * @return int|string
     */
    protected function getId()
    {
        return $this->id;
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
            $this->data = $this->dbResult->getOutput();
        }
        return $this->data;
    }

    /**
     * @param string $key
     * @return mixed
     */
    protected function getData($key)
    {
        if (!array_key_exists($key, $this->schema)) {
            throw new InvalidArgumentException("{$key} is not define in LeModelAbstract::schema");
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
        return $this->schema_has_call_backs;
    }

    protected function schemaUsesCallBacks()
    {
        $this->schema_has_call_backs = true;
    }

    /**
     * LeModelAbstract constructor.
     * @param LeDbService $db
     */
    protected function __construct(LeDbService $db)
    {
        $this->setPrimaryKey();
        $this->setSchema();
        $this->setTableName();
        $this->db = $db;
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
     * @param LeDbService $db
     * @return LeModelAbstract|null
     */
    public static function initWithId($id, LeDbService $db)
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
     * @param LeDbService $db
     * @return LeModelAbstract|null
     */
    public static function initWithArray(array $input, LeDbService $db)
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
    //</editor-fold>

    //<editor-fold desc="Core DB Functions">
    /**
     * @return bool|int
     */
    public function save()
    {
        if (is_null($this->getId())) {
            $output = $this->insert();
        } else {
            $output = $this->update();
        }
        return $output;
    }

    /**
     * @return int|false
     */
    protected function update()
    {
        $cols = [];
        foreach (array_keys($this->data) as $col) {
            $cols[] = "`{$col}` = ?";
        }
        $bindings = [];
        if ($this->doesSchemaUseCallBacks()) {
            foreach ($this->data as $column => $value) {
                $attrs = $this->schema[$column];
                if (isset($attrs['call_back_get']) && $call_back = $attrs['call_back_get']) {
                    $value = $this->$call_back($value);
                }
                $bindings[] = $value;
            }
        } else {
            $bindings = array_values($this->data);
        }
        $bindings[] = $this->id;
        $sql = "UPDATE `{$this->getTableName()}` SET " .
            implode(', ', $cols) . " WHERE `{$this->getPrimaryKey()}` = ?;";
        $this->dbResult = $this->getDb()->execute($sql, $bindings);
        if ($this->dbResult->success()) {
            $output = $this->dbResult->getRowsAffected();
        } else {
            $output = false;
        }
        return $output;
    }

    /**
     * @return int|false
     */
    protected function insert()
    {
        $cols = array_keys($this->data);
        $needles = array_fill(0, count($cols), '?');
        $bindings = [];
        if ($this->doesSchemaUseCallBacks()) {
            foreach ($this->data as $column => $value) {
                $attrs = $this->schema[$column];
                if (isset($attrs['call_back_get']) && $call_back = $attrs['call_back_get']) {
                    $value = $this->$call_back($value);
                }
                $bindings[] = $value;
            }
        } else {
            $bindings = array_values($this->data);
        }
        $sql = "INSERT INTO `{$this->getTableName()}` (`" . implode('`, `', $cols) . "`) " .
            "VALUES (" . implode(', ', $needles) . ");";
        $this->dbResult = $this->getDb()->execute($sql, $bindings);
        if ($this->dbResult->success()) {
            $output = $this->dbResult->getLastInsertId();
            $this->loadFromId($output, true);
        } else {
            $output = false;
        }
        return $output;
    }

    /**
     * @param $id
     * @param bool $use_prime
     */
    protected function loadFromId($id, $use_prime = false)
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE {$this->primary_key} = ?";
        $result = $this->db->execute($sql, [$id], false, $use_prime);
        if ($result->success()) {
            $this->loadData($result->getFirstRow());
        }
    }

    /**
     * @param array $input
     */
    protected function loadData(array $input)
    {
        foreach ($this->schema as $column => $attrs) {
            if (isset($input[$column])) {
                $value = $input[$column];
                if ($this->getPrimaryKey() == $column) {
                    $this->id = $value;
                }
                if (!is_null($attrs['length']) && 'string' == $attrs['type']) {
                    $value = substr($value, 0, $attrs['length']);
                }
            } else {
                $value = null;
            }
            if (isset($attrs['call_back_set']) && $call_back = $attrs['call_back_set']) {
                $this->$call_back($value);
            } else {
                $this->data[$column] = $value;
            }
        }
    }
    //</editor-fold>
}
