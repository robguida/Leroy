<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 4:05 PM
 */

namespace LeroyTest\LeMVCS;

use Exception;
use LeroyTestLib\LeroyUnitTestAbstract;
use LeroyTestResource\LeModelAbstractTestObject;
use LeroyTestResource\LeModelWithCallBacksTestObject;

class LeModelAbstractTest extends LeroyUnitTestAbstract
{
    /**
     * @throws Exception
     */
    public function testInstantiate()
    {
        $model = new LeModelAbstractTestObject($this->db);
        $this->assertInstanceOf('LeroyTestResource\LeModelAbstractTestObject', $model);
        $this->assertInstanceOf('Leroy\LeMVCS\LeModelAbstract', $model);
        $this->assertInstanceOf('Leroy\LeDb\LeDbService', $model->getDb());
        $this->assertArrayHasKey('address_1', $model->getSchema());
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
        $model = LeModelAbstractTestObject::initWithId($id, $this->db);
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
        $model2 = LeModelAbstractTestObject::initWithArray($model->getAllData(), $this->db);
        $this->assertInstanceOf('Leroy\LeMVCS\LeModelAbstract', $model2);
        $this->assertEquals(1, $model2->getAddressId());
        $this->assertEquals('1 Phoenix St', $model2->getAddress1());
        $this->assertEquals('Devon', $model2->getCity());
        $this->assertEquals('PA', $model2->getState());
        $this->assertInstanceOf('DateTime', $model2->getDateAdded());
    }

    /**
     * Ex
     */
    public function testCallBack()
    {
        $this->markTestSkipped('I have debugged the callback and it works. I just need to figure how to make the test');
        $model = new LeModelWithCallBacksTestObject($this->db);
        $model->setAddress1('1 Phoenix St');
        $model->setCity('Devon');
        $model->setState('PA');
        $id = $model->save();
        $this->assertEquals(1, $id);
        //$model2 = LeModelWithCallBacksTestObject::initWithId($model->getAddressId(), $this->db);
        $model2 = $this->getMockBuilder(LeModelWithCallBacksTestObject::class)
            ->setMethods(['initWithId', 'setAddress1', 'setCity'])
            ->getMock();
        $model2->expects($this->once())->method('setAddress1');
        $this->assertsEquals($model->getAddressId(), $this->db);
    }

    private function insertRecord($return_object = false)
    {
        $model = new LeModelAbstractTestObject($this->db);
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
