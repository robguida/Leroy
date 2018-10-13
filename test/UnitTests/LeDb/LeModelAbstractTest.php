<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 4:05 PM
 */

namespace LeroysBacksideTest\LeDb;

use Exception;
use LeroysBackside\LeDb\LeDbService;
use LeroysBacksideTestLib\LeroysBacksideUnitTestAbstract;
use LeroysBacksideTestResource\LeModelTestObject;

class LeModelAbstractTest extends LeroysBacksideUnitTestAbstract
{
    /**
     * @throws Exception
     */
    public function testInstantiate()
    {
        $model = new LeModelTestObject($this->db);
        $this->assertInstanceOf('LeroysBacksideTestResource\LeModelTestObject', $model);
        $this->assertInstanceOf('LeroysBackside\LeDb\LeModelAbstract', $model);
        $this->assertInstanceOf('LeroysBackside\LeDb\LeDbService', $model->getDb());
        $this->assertArrayHasKey('address_id', $model->getSchema());
        $this->assertEquals('address', $model->getTableName());
        $this->assertEquals('address_id', $model->getPrimaryKey());
    }

    public function testSaveInsert()
    {
        $model = $this->insertRecord(true);
        $this->assertArrayHasKey('address_id', $model->getAllData());
        $this->assertEquals(1, $model->getAddressId());
        $this->assertEquals('1 Phoenix St', $model->getAddress1());
        $this->assertEquals('Devon', $model->getCity());
        $this->assertEquals('PA', $model->getState());
        $this->assertInstanceOf('DateTime', $model->getDateAdded());
    }

    public function testSaveUpdateAndInitWithId()
    {
        $id = $this->insertRecord();
        $model = LeModelTestObject::initWithId($id, $this->db);
        $model->setCity('Wayne');
        $result = $model->save();
        $this->assertEquals(1, $result);
        $this->assertEquals(1, $model->getAddressId());
        $this->assertEquals('1 Phoenix St', $model->getAddress1());
        $this->assertEquals('Wayne', $model->getCity());
        $this->assertEquals('PA', $model->getState());
        $this->assertInstanceOf('DateTime', $model->getDateAdded());
    }

    public function testLoadFromArray()
    {
        $model = $this->insertRecord(true);
        $model2 = LeModelTestObject::initWithArray($model->getAllData(), $this->db);
        echo __METHOD__ . ' $model2: ' . print_r($model2->getAllData(), true) . PHP_EOL;
        $this->assertInstanceOf('LeroysBackside\LeDb\LeModelAbstract', $model2);
        $this->assertEquals(1, $model2->getAddressId());
        $this->assertEquals('1 Phoenix St', $model2->getAddress1());
        $this->assertEquals('Devon', $model2->getCity());
        $this->assertEquals('PA', $model2->getState());
        $this->assertInstanceOf('DateTime', $model2->getDateAdded());
    }

    private function insertRecord($return_object = false)
    {
        $model = new LeModelTestObject($this->db);
        $model->setAddress1('1 Phoenix St');
        $model->setCity('Devon');
        $model->setState('PA');
        $output = $model->save();
        if ($return_object) {
            $output = $model;
        }
        return $output;
    }
}
