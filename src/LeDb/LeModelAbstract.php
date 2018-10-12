<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 11:45 AM
 */

namespace LeroysBackside\LeDb;

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
    /** @var array */
    private $data = [];
    /** @var LeDbService */
    protected $db;

    /**
     * LeModelAbstract constructor.
     * @param LeDbService $db
     */
    protected function __construct(LeDbService $db)
    {
        $this->db = $db;
    }

    abstract protected function setPrimaryKey();
    abstract protected function setSchema();
    abstract protected function setTableName();

    /**
     * @param int|string $id
     * @param LeDbService $db
     * @return LeModelAbstract|null
     */
    public static function loadFromId($id, LeDbService $db)
    {
        /**
         * @var LeModelAbstract $model
         * @var LeDbResultInterface $result
         */

        $class = get_called_class();
        $model = new $class($db);
        $sql = "SELECT * FROM {$model->table_name} WHERE {$model->primary_key} = ?";
        $result = $model->db->execute($sql, [$id]);
        if ($result->success()) {
            $model->loadData($result->fetchAssoc());
            $output = $model;
        } else {
            $output = null;
        }
        return $output;
    }
//
//    /**
//     * @param array $input
//     * @param LeDbService $db
//     * @return SiteModel
//     */
//    public static function loadFromArray(array $input, LeDbService $db)
//    {
//        $output = new SiteModel($db);
//        return $output;
//    }
//
//    /**
//     * @throws Exception
//     */
//    public function save()
//    {
//        if (is_null($this->getSiteId())) {
//            $output = $this->insert();
//        } else {
//            $output = $this->update();
//        }
//        return $output;
//    }
//
//    /**
//     * @throws Exception
//     */
//    protected function insert()
//    {
//        $cols = [];
//        $bindings = [];
//
//        if (!is_null($this->getSiteName())) {
//            $cols[] = 'site_name = ?';
//            $bindings[] = $this->getSiteName();
//        } else {
//            throw new Exception('Site name is required for this record.');
//        }
//
//        $sql = 'INSERT INTO site (site_name) VALUES (?);';
//        /** @var LeDbResultInterface $result */
//        $result = $this->getDb()->execute($sql, $bindings);
//        print_r($result);
//        $this->setSiteId($result->getLastInsertId());
//        return $this->getSiteId();
//    }
//
//    /**
//     * @return integer|boolean
//     * @throws Exception
//     */
//    protected function update()
//    {
//        $output = false;
//        $sets = [];
//        $bindings = [];
//        if (!is_null($this->getSiteName())) {
//            $sets[] = 'site_name = ?';
//            $bindings[] = $this->getSiteName();
//        }
//
//        if (!empty($sets)) {
//            $bindings[] = $this->getSiteId();
//            $sql = 'UPDATE site SET ' . implode(', ', $sets) . ' WHERE site_id = ?';
//            $result = $this->getDb()->execute($sql, $bindings);
//            $output = $result->getRowsAffected();
//        }
//        return $output;
//    }
//
    /**
     * @param array $input
     */
    protected function loadData(array $input)
    {
        foreach ($this->schema as $column => $attrs) {
            if (isset($input[$column])) {
                $value = $input[$column];
                if ('string' == $attrs['type']) {
                    $value = substr($value, 0, $attrs['length']);
                }
            } else {
                $value = null;
            }
            $this->data[$column] = $value;
        }
    }
}
