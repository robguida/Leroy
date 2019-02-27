<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/7/2018
 * Time: 12:37 AM
 */

namespace LeroyTestLib;

use Leroy\LeDb\LeDbService;
use PHPUnit\Framework\TestCase;

abstract class LeroyUnitTestAbstract extends TestCase
{
    protected $db;

    protected function setUp()
    {
        $this->db = LeDbService::init('leroy', DBCONFIGFILE1);
        $this->db->execute('TRUNCATE TABLE address;');
        $this->db->execute('TRUNCATE TABLE contact;');
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
