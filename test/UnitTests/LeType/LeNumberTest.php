<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 9:31 PM
 */

namespace LeroyTest\LeType;

use Exception;
use InvalidArgumentException;
use Leroy\LeType\LeNumber;
use LeroyTestLib\LeroyUnitTestAbstract;

class LeNumberTest extends LeroyUnitTestAbstract
{
    public function testNumericType()
    {
        $values = ['test', LeNumber::getMin(), LeNumber::getMax(), 'string'];
        foreach ($values as $value) {
            try {
                $number = LeNumber::init($value);
                $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
                $this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                $this->assertEquals("{$value} is not numeric", $e->getMessage());
            }
        }
    }

    public function testMinMaxNumberic()
    {
        $number = LeNumber::init(20, 19, 20);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        $number = LeNumber::init(20, 19, 21);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        $number = LeNumber::init(20, 20, 20);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        $number = LeNumber::init(20, 20, 21);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMinNumericFailed()
    {
        LeNumber::init(20, 21);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMaxNumericFailed()
    {
        LeNumber::init(20, 1, 19);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUnSignedNumeric()
    {
        $number = LeNumber::init(1, null, null, false);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        LeNumber::init(-1, null, null, false);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSignedNumeric()
    {
        $number = LeNumber::init(-1, null, null, true);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        $this->assertTrue($number->isSigned());
        LeNumber::init(-1, null, null, false);
    }

    public function testPrecision()
    {
        $number = LeNumber::init(123.456, null, null, null, 2);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        $this->assertEquals(123.46, $number->get());
        $this->assertEquals(2, $number->getPrecision());
    }
}
