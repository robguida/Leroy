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
        $db = LeDbService::init('leroysbackside', DBCONFIGFILE1);
        $model = new LeModelTestObject($db);
        $this->assertInstanceOf('LeroysBacksideTestResource\LeModelTestObject', $model);
        $this->assertInstanceOf('LeroysBackside\LeDb\LeModelAbstract', $model);
    }
}
