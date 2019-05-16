<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/7/2018
 * Time: 12:11 AM
 */

namespace LeroyTest\LeDb\LeDbServiceTests;

require_once '/var/www/Leroy/src/bootstrap.php';

use DateTime;
use Exception;
use Leroy\LeDb\LeDbService;
use LeroyTestLib\LeroyUnitTestAbstract;

/**
 * Class LeDbServiceDbConnFileTest
 * @package LeroyTest\LeDb\LeDbServiceTests
 */
class LeDbServiceDbConnArrayTest extends LeroyUnitTestAbstract
{
    public function testInstantiated()
    {
        $db = LeDbService::init('leroy', $this->getDbConnArray());
        $this->assertInstanceOf('Leroy\LeDb\LeDbService', $db);
        $db2 = LeDbService::init('leroy', DBCONFIGFILE2);
        $this->assertInstanceOf('Leroy\LeDb\LeDbService', $db2);
    }

    public function testPdoStatement()
    {
        $db = LeDbService::init('leroy', $this->getDbConnArray());
        $result = $db->execute('SELECT * FROM contact;');
        $this->assertTrue($result->success());
        $this->assertInstanceOf('PDOStatement', $result->getPdoStatement());
        $this->assertNull($result->getErrorCode());
        $this->assertNull($result->getErrorInfo());
    }

    public function testException4200()
    {
        $db = LeDbService::init('leroy', $this->getDbConnArray());
        $result = $db->execute('This is a bad query;');
        $this->assertFalse($result->success());
        $this->assertNotInstanceOf('PDOStatement', $result->getPdoStatement());
        $this->assertInstanceOf('Exception', $result->getException());
        $this->assertEquals('42000', $result->getErrorCode());
        $this->assertEquals(
            'SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; '.
            'check the manual that corresponds to your MySQL server version for the right syntax to use near ' .
            '\'This is a bad query\' at line 1',
            $result->getErrorInfo()
        );
    }

    public function testException42S02()
    {
        $db = LeDbService::init('leroy', $this->getDbConnArray());
        $result = $db->execute('SELECT * FROM contacts;');
        $this->assertEquals('42S02', $result->getErrorCode());
        $this->assertEquals(
            "SQLSTATE[42S02]: Base table or view not found: 1146 Table 'leroy.contacts' doesn't exist",
            $result->getErrorInfo()
        );
    }

    /**
     * @throws Exception
     *
     */
    public function testValueExceedsDataLength()
    {
        $db = LeDbService::init('leroy', $this->getDbConnArray());
        $sql = 'INSERT INTO address (address_1, city, state)
                VALUES
                ("12345678901234567890123456789012345678901234567890",
                "12345678901234567890123456789012345678901234567890",
                "12345678901234567890123456789012345678901234567890");';
        $result = $db->execute($sql);
        $this->assertNotInstanceOf('PDOStatement', $result->getPdoStatement());
        $this->assertInstanceOf('Exception', $result->getException());
    }

    public function testQueriesAndDifferentConfigFiles()
    {
        $this->markTestIncomplete('issues with getting PDO::queryString');
        foreach ($this->connectionsAndQueries1() as $dsn => $queries) {
            $db = LeDbService::init($dsn, $this->getDbConnArray());
            $result1 = $db->execute($queries['truncate']);
            $result2 = $db->execute($queries['insert']);
            $result3 = $db->execute($queries['select']);

            $this->assertEquals($queries['truncate'], $result1->getSql());
            $this->assertEquals(0, $result1->getRowsAffected());

            $this->assertEquals($queries['insert'], $result2->getSql());
            $this->assertEquals(1, $result2->getLastInsertId());
            $this->assertEquals(1, $result2->getRowsAffected());

            $this->assertEquals($queries['select'], $result3->getSql());
            $this->assertEquals(1, $result3->getFirstValue());
            $this->assertEquals(1, $result3->getRecordCount());
        }
        foreach ($this->connectionsAndQueries2() as $dsn => $queries) {
            $db = LeDbService::init($dsn, DBCONFIGFILE2);
            $result1 = $db->execute($queries['truncate']);
            $result2 = $db->execute($queries['insert']);
            $result3 = $db->execute($queries['select']);

            $this->assertEquals($queries['truncate'], $result1->getSql());

            $this->assertEquals($queries['insert'], $result2->getSql());
            $this->assertEquals(1, $result2->getLastInsertId());
            $this->assertEquals(1, $result2->getRowsAffected());

            $this->assertEquals($queries['select'], $result3->getSql());
            $this->assertEquals(1, $result3->getFirstValue());
            $this->assertEquals(1, $result3->getRecordCount());
        }
    }

    public function testQueriesWithBindings()
    {
        $this->markTestIncomplete('issues with getting PDO::queryString');
        foreach ($this->connectionsAndBoundQueries() as $dsn => $queries) {
            if ('leroy' == $dsn) {
                $db = LeDbService::init($dsn, $this->getDbConnArray());
                $db->execute($queries['truncate']);

                $result = $db->execute($queries['insert'], ['jane', 'doe']);
                $this->assertEquals($queries['insert'], $result->getSql());
                $this->assertEquals(1, $result->getLastInsertId());
                $this->assertEquals(1, $result->getRowsAffected());

                $result2 = $db->execute($queries['select'], ['jane', 'doe']);
                $rs = $result2->getFirstRow();
                $dateAdded = new DateTime($rs['date_created']);
                $this->assertEquals(1, $result2->getRecordCount());
                $this->assertEquals($queries['select'], $result2->getSql());
                $this->assertEquals($result->getLastInsertId(), $rs['contact_id']);
                $this->assertEquals('jane', $rs['first_name']);
                $this->assertEquals('doe', $rs['last_name']);
                $this->assertEquals((new DateTime())->format('Y-m-d'), $dateAdded->format('Y-m-d'));
            } else {
                $db = LeDbService::init($dsn, DBCONFIGFILE2);
                $db->execute($queries['truncate']);

                $result = $db->execute($queries['insert'], ['1 Abby Road', 'London', 'England']);
                $this->assertEquals($queries['insert'], $result->getSql());
                $this->assertEquals(1, $result->getLastInsertId());
                $this->assertEquals(1, $result->getRowsAffected());

                $result2 = $db->execute($queries['select'], ['1 Abby Road', 'London', 'England']);
                $this->assertEquals($queries['select'], $result2->getSql());
                $rs = $result2->getFirstRow();
                $dateAdded = new DateTime($rs['date_created']);
                $this->assertEquals(1, $result2->getRecordCount());
                $this->assertEquals($result->getLastInsertId(), $rs['address_id']);
                $this->assertEquals('1 Abby Road', $rs['address_1']);
                $this->assertEquals('London', $rs['city']);
                $this->assertEquals('England', $rs['state']);
                $this->assertEquals((new DateTime())->format('Y-m-d'), $dateAdded->format('Y-m-d'));
            }
        }
    }

    public function testQueriesWithAssociatedBindings()
    {
        $this->markTestIncomplete('issues with getting PDO::queryString');
        foreach ($this->connectionsAndAssociativelyBoundQueries() as $dsn => $queries) {
            if ('leroy2' == $dsn) {
                $db = LeDbService::init($dsn, $this->getDbConnArray());
                $db->execute($queries['truncate']);

                $result = $db->execute($queries['insert'], ['last_name' => 'jane', 'first_name' => 'doe'], true);
                $this->assertEquals($queries['insert'], $result->getSql());
                $this->assertEquals(1, $result->getLastInsertId());
                $this->assertEquals(1, $result->getRowsAffected());

                $result2 = $db->execute($queries['select'], ['last_name' => 'jane', 'first_name' => 'doe'], true);
                $rs = $result2->getFirstRow();
                $dateAdded = new DateTime($rs['date_created']);
                $this->assertEquals(1, $result2->getRecordCount());
                $this->assertEquals($queries['select'], $result2->getSql());
                $this->assertEquals($result->getLastInsertId(), $rs['contact_id']);
                $this->assertEquals('jane', $rs['last_name']);
                $this->assertEquals('doe', $rs['first_name']);
                $this->assertEquals((new DateTime())->format('Y-m-d'), $dateAdded->format('Y-m-d'));
            } else {
                $db = LeDbService::init($dsn, DBCONFIGFILE2);
                $db->execute($queries['truncate']);

                $result = $db->execute(
                    $queries['insert'],
                    ['address_1' =>'1 Abby Road', 'city' => 'London', 'state' => 'England']
                );
                $this->assertEquals($queries['insert'], $result->getSql());
                $this->assertEquals(1, $result->getLastInsertId());
                $this->assertEquals(1, $result->getRowsAffected());

                $result2 = $db->execute(
                    $queries['select'],
                    ['address_1' =>'1 Abby Road', 'city' => 'London', 'state' => 'England']
                );
                $rs = $result2->getFirstRow();
                $dateAdded = new DateTime($rs['date_created']);
                $this->assertEquals(1, $result2->getRecordCount());
                $this->assertEquals($queries['select'], $result2->getSql());
                $this->assertEquals($result->getLastInsertId(), $rs['address_id']);
                $this->assertEquals('1 Abby Road', $rs['address_1']);
                $this->assertEquals('London', $rs['city']);
                $this->assertEquals('England', $rs['state']);
                $this->assertEquals((new DateTime())->format('Y-m-d'), $dateAdded->format('Y-m-d'));
            }
        }
    }

    public function testGetRowsCount()
    {
        $db = LeDbService::init('leroy', $this->getDbConnArray());
        $db->execute('TRUNCATE TABLE contact');

        $sql = 'INSERT INTO contact (last_name, first_name) VALUES (\'jane\', \'doe\');';
        $result = $db->execute($sql);
        $this->assertEquals(1, $result->getRowsAffected());
        $this->assertEquals(1, $result->getLastInsertId());
        $this->assertEquals(0, $result->getRecordCount());

        $sql = 'SELECT * FROM contact;';
        $result2 = $db->execute($sql);
        $this->assertEquals(1, $result2->getRecordCount());

        $sql = 'INSERT INTO contact (last_name, first_name) VALUES (\'doe\', \'jane\');';
        $result = $db->execute($sql);
        $this->assertEquals(1, $result->getRowsAffected());
        $this->assertEquals(2, $result->getLastInsertId());
        $this->assertEquals(0, $result->getRecordCount());

        $sql = 'SELECT * FROM contact;';
        $result2 = $db->execute($sql);
        $this->assertEquals(2, $result2->getRecordCount());
    }

    public function testRowsFound()
    {
        $db = LeDbService::init('leroy', $this->getDbConnArray());
        $db->execute('TRUNCATE TABLE contact');

        $sql = 'INSERT INTO contact (last_name, first_name)
                VALUES (\'jane\', \'doe\'),  (\'doe\', \'jane\'),  (\'doe\', \'jim\')
                    ,  (\'jane\', \'calamity\'),  (\'doe\', \'joe\'),  (\'doe\', \'pogo\')
                    ,  (\'janes\', \'poggota\'),  (\'doe\', \'Fred\'),  (\'doe\', \'Slim\');';
        $db->execute($sql);

        $sql = 'SELECT SQL_CALC_FOUND_ROWS first_name, last_name FROM contact LIMIT 2';
        $result = $db->execute($sql);
        $this->assertEquals(9, $result->getRowsFound());
        $this->assertEquals(2, $result->getRecordCount());
    }

    public function testGetRowsAffectedWhenNoValueChanges()
    {
        $db = LeDbService::init('leroy', $this->getDbConnArray());
        $db->execute('TRUNCATE TABLE contact');
        $bindings = ['jane', 'doe'];
        $sql = 'INSERT INTO contact (last_name, first_name) VALUES (?, ?);';
        $result = $db->execute($sql, $bindings);
        $this->assertEquals(1, $result->getRowsAffected());
        $sql_update = 'UPDATE contact SET last_name = ?, first_name = ? WHERE contact_id = ?';
        $bindings[] = $result->getLastInsertId();
        $result2 = $db->execute($sql_update, $bindings);
        $this->assertEquals(1, $result2->getRowsAffected());
        $sql_delete = 'DELETE FROM contact WHERE contact_id = ?';
        $result3 = $db->execute($sql_delete, [$result->getLastInsertId()]);
        $this->assertEquals(1, $result3->getRowsAffected());
    }

    public function testGetRowsAffectedWhenValuesChange()
    {
        $db = LeDbService::init('leroy', $this->getDbConnArray());
        $db->execute('TRUNCATE TABLE contact');
        foreach ($this->getDataForContactNotAssociated() as $bindings) {
            $sql = 'INSERT INTO contact (last_name, first_name) VALUES (?, ?);';
            $db->execute($sql, $bindings);
        }
        $sql = "UPDATE contact SET last_name = CONCAT('estare', contact_id) WHERE first_name = 'jane';";
        $result = $db->execute($sql);
        $this->assertEquals(4, $result->getRowsAffected());
    }

    public function testDuplicateErrorWithNoDupeErrorFlagSet()
    {
        $db = LeDbService::init('leroy', $this->getDbConnArray());
        $bindings = ['ethyl', 'fred'];
        $sql = 'INSERT INTO contact (last_name, first_name) VALUES (?, ?);';
        $db->execute($sql, $bindings);
        $result2 = $db->execute($sql, $bindings);
        $this->assertFalse($result2->success());
        $this->assertEquals('23000', $result2->getErrorCode());
        $this->assertEquals(
            'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'fred-ethyl\' for key ' .
            '\'UIX_contact_1\'',
            $result2->getErrorInfo()
        );
    }

    private function connectionsAndQueries1()
    {
        return [
            'leroy' => [
                'truncate' => 'TRUNCATE TABLE contact;',
                'insert' => 'INSERT INTO contact (first_name, last_name) VALUES ("John", "Doe");',
                'select' => 'SELECT COUNT(*) as cnt FROM contact;',
            ],
            'leroy2' => [
                'truncate' => 'TRUNCATE TABLE address;',
                'insert' => 'INSERT INTO address (address_1, city, state) VALUES ("912 Feist Ave", "Pottstown", "PA");',
                'select' => 'SELECT COUNT(*) as cnt FROM address;',
            ],
        ];
    }

    private function connectionsAndQueries2()
    {
        return [
            'leroy2' => [
                'truncate' => 'TRUNCATE TABLE contact;',
                'insert' => 'INSERT INTO contact (first_name, last_name) VALUES ("John", "Doe");',
                'select' => 'SELECT COUNT(*) as cnt FROM contact;',
            ],
            'leroy4' => [
                'truncate' => 'TRUNCATE TABLE address;',
                'insert' => 'INSERT INTO address (address_1, city, state) VALUES ("912 Feist Ave", "Pottstown", "PA");',
                'select' => 'SELECT COUNT(*) as cnt FROM address;',
            ],
        ];
    }

    private function connectionsAndBoundQueries()
    {
        return [
            'leroy' => [
                'truncate' => 'TRUNCATE TABLE contact;',
                'insert' => 'INSERT INTO contact (first_name, last_name) VALUES (?, ?);',
                'select' => 'SELECT * FROM contact WHERE first_name = ? AND last_name = ?;',
            ],
            'leroy3' => [
                'truncate' => 'TRUNCATE TABLE address;',
                'insert' => 'INSERT INTO address (address_1, city, state) VALUES (?, ?, ?);',
                'select' => 'SELECT * FROM address WHERE address_1 = ? AND city = ? AND state = ?;',
            ],
        ];
    }

    private function connectionsAndAssociativelyBoundQueries()
    {
        return [
            'leroy2' => [
                'truncate' => 'TRUNCATE TABLE contact;',
                'insert' => 'INSERT INTO contact (last_name, first_name)
                                  VALUES (:last_name, :first_name);',
                'select' => 'SELECT * FROM contact
                              WHERE first_name = :first_name AND last_name = :last_name;',
            ],
            'leroy4' => [
                'truncate' => 'TRUNCATE TABLE address;',
                'insert' => 'INSERT INTO address (state, address_1, city)
                              VALUES (:state, :address_1, :city);',
                'select' => 'SELECT * FROM address
                              WHERE state = :state AND city = :city AND address_1 = :address_1;',
            ],
        ];
    }
}
