<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 4:05 PM
 */

namespace LeroyTest\LeMVCS;

require_once '/var/www/Leroy/src/bootstrap.php';

use DateTime;
use Exception;
use LeroyTestLib\LeroyUnitTestAbstract;
use LeroyTestResource\AddressModel;
use LeroyTestResource\LeModelAbstractTestObject;
use LeroyTestResource\LeModelWithCallBacksTestObject;

class LeModelAbstractTest extends LeroyUnitTestAbstract
{
    private $address = '100 Fleet Street';
    private $city = 'Annapolis';
    private $state = 'MD';
    
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
        $this->assertEquals($this->address, $model->getAddress1());
        $this->assertEquals($this->city, $model->getCity());
        $this->assertEquals($this->state, $model->getState());
        $this->assertionsForDateCreatedAndModified($model);
        $this->assertionsForFunctionsUsed($model);
    }

    public function testSaveUpdateAndInitWithId()
    {
        $id = $this->insertRecord();
        $model = AddressModel::initWithId($id, $this->db);
        $model->setCity('Wayne');
        $result = $model->save();
        $this->assertEquals(1, $result);
        $this->assertEquals(1, $model->getId());
        $this->assertEquals($this->address, $model->getAddress1());
        $this->assertEquals('Wayne', $model->getCity());
        $this->assertEquals($this->state, $model->getState());
        $this->assertionsForDateCreatedAndModified($model);
        $this->assertionsForFunctionsUsed($model);
    }

    public function testLoadFromArray()
    {
        $model = $this->insertRecord(true);
        $model2 = AddressModel::initWithArray($model->getAllData(), $this->db);
        $this->assertInstanceOf('Leroy\LeMVCS\LeModelAbstract', $model2);
        $this->assertEquals(1, $model2->getId());
        $this->assertEquals($this->address, $model2->getAddress1());
        $this->assertEquals($this->city, $model2->getCity());
        $this->assertEquals($this->state, $model2->getState());
        $this->assertTrue(is_array($model2->getAllData()));
        $this->assertionsForDateCreatedAndModified($model);
        $this->assertionsForFunctionsUsed($model);
    }

    public function testCannotSetValuesWhereTheColumnUsesCURRETNT_TIMESTAMP()
    {
        $bad_date_created = '1986-06-20';
        $bad_date_modified = '1987-07-21';
        $model = new AddressModel();
        $model->setAddress1($this->address);
        $model->setCity($this->city);
        $model->setState($this->state);
        $model->setDateCreated($bad_date_created);
        $model->setDateModified($bad_date_modified);
        $model->save();
        list($dateCreated, $dateModified) = $this->assertionsForDateCreatedAndModified($model);
        $this->assertNotEquals($dateCreated->format('Y-m-d'), $bad_date_created);
        $this->assertNotEquals($dateModified->format('Y-m-d'), $bad_date_created);
        $this->assertionsForFunctionsUsed($model);
    }

    /**
     * @param bool $return_object
     * @return bool|int|AddressModel
     */
    private function insertRecord($return_object = false)
    {
        $addressModel = new AddressModel();
        $addressModel->setAddress1($this->address);
        $addressModel->setCity($this->city);
        $addressModel->setState($this->state);
        $output = $addressModel->save();
        if ($return_object) {
            $output = $addressModel;
        }
        return $output;
    }

    /**
     * @param AddressModel $addressModel
     * @return array
     */
    private function assertionsForDateCreatedAndModified(AddressModel $addressModel): array
    {
        $expected = new DateTime();
        $dateCreated = new DateTime($addressModel->getDateCreated());
        $dateModified = new DateTime($addressModel->getDateModified());
        $this->assertEquals($expected->format('Y-m-d H:i'), $dateCreated->format('Y-m-d H:i'));
        $this->assertEquals($expected->format('Y-m-d H:i'), $dateModified->format('Y-m-d H:i'));
        return array($dateCreated, $dateModified);
    }

    /**
     * @param $model
     */
    private function assertionsForFunctionsUsed($model): void
    {
        foreach ($model->functions_used as $function) {
            $this->assertTrue(in_array($function, [
                'getAddress1Test',
                'getCityTest',
                'getStateTest',
                'setAddress1Test',
                'setCityTest',
                'setStateTest',
            ]));
        }
    }
}
