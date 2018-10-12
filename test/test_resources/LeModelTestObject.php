<?php

namespace LeroysBacksideTestResource;

use LeroysBackside\LeDb\LeDbService;
use LeroysBackside\LeDb\LeModelAbstract;

/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 4:08 PM
 */
class LeModelTestObject extends LeModelAbstract
{

    protected function setPrimaryKey()
    {
        $this->primary_key = 'address_1';
    }

    protected function setSchema()
    {
        $this->schema = [
            'address_id' => [
                'type' => 'integer',
                'length' => 10
            ],
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
                'length' => 45
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
    public function __construct(LeDbService $db)
    {
        parent::__construct($db);
    }
}
