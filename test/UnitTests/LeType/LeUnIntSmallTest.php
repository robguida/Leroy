<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 9:48 PM
 */

namespace LeroysBacksideTest\LeType;

use Exception;
use LeroysBackside\LeType\LeUnIntSmall;
use LeroysBacksideTestLib\LeroysBacksideUnitTestAbstract;

class LeUnIntSmallTest extends LeroysBacksideUnitTestAbstract
{
    public function testLeUnIntSmall()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeUnIntSmall::getMin(), LeUnIntSmall::getMax());
        }
        $i = 0;
        foreach ($values as $value) {
            try {
                $number = LeUnIntSmall::set($value);
                $this->assertInstanceOf('LeroysBackside\LeType\LeUnIntSmall', $number);
                $this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                if (2 >= $i) {
                    $this->assertEquals("{$value} is not numeric", $e->getMessage());
                } else {
                    $this->assertEquals("{$value} cannot be greater than " . LeUnIntSmall::getMax(), $e->getMessage());
                }
            }
            $i++;
        }
    }

    public function testLeUnIntSmallValidate()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        foreach ($values as $value) {
            $number = LeUnIntSmall::verify($value);
            $this->assertFalse($number);
        }
        $values = [];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeUnIntSmall::getMin(), LeUnIntSmall::getMax());
        }
        foreach ($values as $value) {
            $number = LeUnIntSmall::verify($value);
            $this->assertInstanceOf('LeroysBackside\LeType\LeUnIntSmall', $number);
        }
    }
}
