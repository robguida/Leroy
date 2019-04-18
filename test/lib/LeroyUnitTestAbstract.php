<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/7/2018
 * Time: 12:37 AM
 */

namespace LeroyTestLib;

use Exception;
use Leroy\LeDb\LeDbService;
use LeroyTestResource\LeModelAbstractTestObject;
use PHPUnit\Framework\TestCase;

abstract class LeroyUnitTestAbstract extends TestCase
{
    /** @var LeDbService */
    protected $db;

    protected function setUp()
    {
        $this->getDbService();
        $this->truncateTables();
    }

    protected function truncateTables()
    {
        $this->getDbService();
        $this->db->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->db->execute('TRUNCATE TABLE address;');
        $this->db->execute('TRUNCATE TABLE contact;');
        $this->db->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }

    /**
     * @return LeDbService
     */
    protected function getDbService()
    {
        if (is_null($this->db)) {
            try {
                $this->db = LeDbService::init('leroy', DBCONFIGFILE1);
            } catch (Exception $e) {
                $this->db = false;
                echo $e->getMessage();
            }
        }
        return $this->db;
    }

    /**
     * @return bool|int
     */
    protected function addAddress()
    {
        $this->getDbService();
        $model = new LeModelAbstractTestObject($this->db);
        $model->setAddress1('3 Fleet St.');
        $model->setCity('Annapolis');
        $model->setState('MD');
        $id = $model->save();
        echo __FILE__ . ' ' . __LINE__ . ' $model:<pre style="text-align: left;">' . print_r($model, true) . '</pre>';
        return $id;
    }
    
    protected function getDbConnArray()
    {
        return [
            "leroy" => [
                "master" => [
                    "host" => "dbmaster.development.com",
                    "userName" => "dev",
                    "password" => "123456",
                    "dbName" => "leroy",
                    "port" => "3306"
                ],
                "slave" => [
                    "0" => [
                        "host" => "dbslave1.development.com",
                        "userName" => "dev",
                        "password" => "123456",
                        "dbName" => "leroy",
                        "port" => "3306"
                    ],
                    "1" => [
                        "host" => "dbslave2.development.com",
                        "userName" => "dev",
                        "password" => "123456",
                        "dbName" => "leroy",
                        "port" => "3306"
                    ]
                ]
            ],
            "leroy2" => [
                "master" => [
                    "host" => "dbmaster2.development.com",
                    "userName" => "dev",
                    "password" => "123456",
                    "dbName" => "leroy",
                    "port" => "3306"
                ],
                "slave" => [
                    "0" => [
                        "host" => "dbslave3.development.com",
                        "userName" => "dev",
                        "password" => "123456",
                        "dbName" => "leroy",
                        "port" => "3306"
                    ],
                    "1" => [
                        "host" => "dbslave4.development.com",
                        "userName" => "dev",
                        "password" => "123456",
                        "dbName" => "leroy",
                        "port" => "3306"
                    ]
                ]
            ]
        ];

    }

    protected function getDataForContactNotAssociated()
    {
        return [
            ['doe', 'jane'],
            ['doe1', 'jane'],
            ['doe2', 'jane'],
            ['doe3', 'jane'],
            ['doe1', 'john'],
            ['doe2', 'jimmy'],
            ['doe3', 'joey'],
            ['doe4', 'james'],
            ['doe5', 'jeffrey'],
            ['doe6', 'jean'],
        ];
    }
}
