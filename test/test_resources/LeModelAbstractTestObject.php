<?php

namespace LeroyTestResource;

use DateTime;
use Leroy\LeDb\LeDbService;
use Leroy\LeMVCS\LeModelAbstract;

/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 4:08 PM
 */
class LeModelAbstractTestObject extends LeModelAbstract
{
    public function setAddress1($input)
    {
        $this->setData('address_1', $input);
    }

    public function setCity($input)
    {
        $this->setData('city', $input);
    }

    public function setState($input)
    {
        $this->setData('state', $input);
    }

    public function setDateAdded($input)
    {
        $this->setData('date_added', $input);
    }

    /**
     * @return int
     */
    public function getAddressId()
    {
        return (int)$this->getId();
    }

    public function getAddress1()
    {
        return $this->getData('address_1');
    }

    public function getCity()
    {
        return $this->getData('city');
    }

    public function getState()
    {
        return $this->getData('state');
    }

    /**
     * @return DateTime|null
     */
    public function getDateAdded()
    {
        $output = null;
        $date_added = parent::getData('date_added');
        if (!empty($date_added)) {
            $output = new DateTime($date_added);
        }
        return $output;
    }

    protected function setPrimaryKey()
    {
        $this->primary_key = 'address_id';
    }

    protected function setSchema()
    {
        $this->schema = [
            'address_1' => [
                'type' => 'string',
                'length' => 45
            ],
            'city' => [
                'type' => 'string',
                'length' => 45
            ],
            'state' => [
                'type' => 'string',
                'length' => 45
            ],
            'date_added' => [
                'type' => 'datetime',
                'length' => null
            ],
        ];
    }

    protected function setTableName()
    {
        $this->table_name = 'address';
    }

    /**
     * LeModelTestObject constructor.
     * @param LeDbService $db
     */
    public function __construct(LeDbService $db = null)
    {
        parent::__construct($db);
    }

    /**
     * @param int $id
     * @param LeDbService $db
     * @return LeModelAbstractTestObject|null
     * @throws \Exception
     */
    public static function initWithId($id, LeDbService $db = null)
    {
        return parent::initWithId($id, $db);
    }

    /**
     * @param array $input
     * @param LeDbService $db
     * @return LeModelAbstractTestObject|null
     * @throws \Exception
     */
    public static function initWithArray(array $input, LeDbService $db = null)
    {
        return parent::initWithArray($input, $db);
    }

    public function getSchema()
    {
        return parent::getSchema();
    }

    public function getAllData()
    {
        return parent::getAllData();
    }

    public function getData(string $key)
    {
        return parent::getData($key);
    }

    public function getTableName()
    {
        return parent::getTableName();
    }

    public function getPrimaryKey()
    {
        return parent::getPrimaryKey();
    }

    public function getDb()
    {
        return parent::getDb();
    }
}
