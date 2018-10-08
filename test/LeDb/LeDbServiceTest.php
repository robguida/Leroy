<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/7/2018
 * Time: 12:11 AM
 */

namespace LeroysBacksideTest\LeDb;

use DateTime;
use LeroysBacksideTest\lib\LeroysBacksideUnitTestAbstract;
use LeroysBackside\LeDb\LeDbService;

class LeDbServiceTest extends LeroysBacksideUnitTestAbstract
{
    public function testInstantiated()
    {
        $db = LeDbService::init('leroysbackside', DBCONFIGFILE1);
        $this->assertInstanceOf('LeroysBackside\LeDb\LeDbService', $db);
        $db2 = LeDbService::init('leroysbackside', DBCONFIGFILE2);
        $this->assertInstanceOf('LeroysBackside\LeDb\LeDbService', $db2);
    }

    public function testPdoStatement()
    {
        $db = LeDbService::init('leroysbackside', DBCONFIGFILE1);
        $result = $db->execute('SELECT * FROM contact;');
        $this->assertTrue($result->success());
        $this->assertInstanceOf('PDOStatement', $result->getPdoStatement());
    }

    public function testException()
    {
        $db = LeDbService::init('leroysbackside', DBCONFIGFILE1);
        $result = $db->execute('This is a bad query;');
        $this->assertFalse($result->success());
        $this->assertNotInstanceOf('PDOStatement', $result->getPdoStatement());
        $this->assertInstanceOf('Exception', $result->getException());
        $this->assertEmpty($result->getErrorCode());
        $this->assertEmpty($result->getErrorInfo());
    }

    public function testQueriesAndDifferentConfigFiles()
    {
        foreach ($this->connectionsAndQueries1() as $dsn => $queries) {
            $db = LeDbService::init($dsn, DBCONFIGFILE1);
            $result1 = $db->execute($queries['truncate']);
            $result2 = $db->execute($queries['insert']);
            $result3 = $db->execute($queries['select']);
            $this->assertEquals($queries['truncate'], $result1->getSql());
            $this->assertEquals($queries['insert'], $result2->getSql());
            $this->assertEquals(1, $result2->getLastInsertId());
            $this->assertEquals($queries['select'], $result3->getSql());
            $this->assertEquals(1, $result3->getFirstValue());
        }
        foreach ($this->connectionsAndQueries2() as $dsn => $queries) {
            $db = LeDbService::init($dsn, DBCONFIGFILE2);
            $result1 = $db->execute($queries['truncate']);
            $result2 = $db->execute($queries['insert']);
            $result3 = $db->execute($queries['select']);
            $this->assertEquals($queries['truncate'], $result1->getSql());
            $this->assertEquals($queries['insert'], $result2->getSql());
            $this->assertEquals(1, $result2->getLastInsertId());
            $this->assertEquals($queries['select'], $result3->getSql());
            $this->assertEquals(1, $result3->getFirstValue());
        }
    }

    public function testQueriesWithBindings()
    {
        foreach ($this->connectionsAndBoundQueries() as $dsn => $queries) {
            if ('leroysbackside' == $dsn) {
                $db = LeDbService::init($dsn, DBCONFIGFILE1);
                $db->execute($queries['truncate']);
                $result = $db->execute($queries['insert'], ['jane', 'doe']);
                $this->assertEquals($queries['insert'], $result->getSql());
                $result2 = $db->execute($queries['select'], ['jane', 'doe']);
                $this->assertEquals($queries['select'], $result2->getSql());
                $rs = $result2->getFirstRow();
                $this->assertEquals($result->getLastInsertId(), $rs['contact_id']);
                $this->assertEquals('jane', $rs['first_name']);
                $this->assertEquals('doe', $rs['last_name']);
                $dateAdded = new DateTime($rs['date_added']);
                $this->assertEquals((new DateTime())->format('Y-m-d'), $dateAdded->format('Y-m-d'));

            } else {
                $db = LeDbService::init($dsn, DBCONFIGFILE1);
                $db->execute($queries['truncate']);
                $result = $db->execute($queries['insert'], ['1 Abby Road', 'London', 'England']);
                $this->assertEquals($queries['insert'], $result->getSql());
                $result2 = $db->execute($queries['select'], ['1 Abby Road', 'London', 'England']);
                $this->assertEquals($queries['select'], $result2->getSql());
                $rs = $result2->getFirstRow();
                $this->assertEquals($result->getLastInsertId(), $rs['address_id']);
                $this->assertEquals('1 Abby Road', $rs['address_1']);
                $this->assertEquals('London', $rs['city']);
                $this->assertEquals('England', $rs['state']);
                $dateAdded = new DateTime($rs['date_added']);
                $this->assertEquals((new DateTime())->format('Y-m-d'), $dateAdded->format('Y-m-d'));
            }
        }
    }

    public function testQueriesWithAssociatedBindings()
    {
        foreach ($this->connectionsAndQueries4() as $dsn => $queries) {
            $db = LeDbService::init($dsn, DBCONFIGFILE1);
            $db->execute($queries['truncate']);
            $result = $db->execute($queries['insert'], ['jane', 'doe']);
            $this->assertEquals($queries['insert'], $result->getSql());
            break;
        }
    }

    private function connectionsAndQueries1()
    {
        return [
            'leroysbackside' => [
                'truncate' => 'TRUNCATE TABLE contact;',
                'insert' => 'INSERT INTO contact (first_name, last_name) VALUES ("John", "Doe");',
                'select' => 'SELECT COUNT(*) as cnt FROM contact;',
            ],
            'leroysbackside2' => [
                'truncate' => 'TRUNCATE TABLE address;',
                'insert' => 'INSERT INTO address (address_1, city, state) VALUES ("912 Feist Ave", "Pottstown", "PA");',
                'select' => 'SELECT COUNT(*) as cnt FROM address;',
            ],
        ];
    }

    private function connectionsAndQueries2()
    {
        return [
            'leroysbackside3' => [
                'truncate' => 'TRUNCATE TABLE contact;',
                'insert' => 'INSERT INTO contact (first_name, last_name) VALUES ("John", "Doe");',
                'select' => 'SELECT COUNT(*) as cnt FROM contact;',
            ],
            'leroysbackside4' => [
                'truncate' => 'TRUNCATE TABLE address;',
                'insert' => 'INSERT INTO address (address_1, city, state) VALUES ("912 Feist Ave", "Pottstown", "PA");',
                'select' => 'SELECT COUNT(*) as cnt FROM address;',
            ],
        ];
    }

    private function connectionsAndBoundQueries()
    {
        return [
            'leroysbackside' => [
                'truncate' => 'TRUNCATE TABLE contact;',
                'insert' => 'INSERT INTO contact (first_name, last_name) VALUES (?, ?);',
                'select' => 'SELECT * FROM contact WHERE first_name = ? AND last_name = ?;',
            ],
            'leroysbackside2' => [
                'truncate' => 'TRUNCATE TABLE address;',
                'insert' => 'INSERT INTO address (address_1, city, state) VALUES (?, ?, ?);',
                'select' => 'SELECT * FROM address WHERE address_1 = ? AND city = ? AND state = ?;',
            ],
        ];
    }

    private function connectionsAndQueries4()
    {
        return [
            'leroysbackside3' => [
                'truncate' => 'TRUNCATE TABLE contact;',
                'insert' => 'INSERT INTO contact (last_name, first_name)
                                  VALUES (:last_name, :first_name);',
                'select' => 'SELECT COUNT(*) as cnt FROM contact
                              WHERE first_name = :first_name AND last_name = :last_name;',
            ],
            'leroysbackside4' => [
                'truncate' => 'TRUNCATE TABLE address;',
                'insert' => 'INSERT INTO address (state, address_1, city)
                              VALUES (:state, :address_1, :city);',
                'select' => 'SELECT COUNT(*) as cnt FROM address
                              WHERE state = :state, city = :city, address_1 = :address_1;',
            ],
        ];
    }
}
