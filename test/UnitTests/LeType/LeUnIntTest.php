<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 9:48 PM
 */

namespace LeroysBacksideTest\LeType;

use Exception;
use LeroysBackside\LeType\LeUnInt;
use LeroysBacksideTestLib\LeroysBacksideUnitTestAbstract;

class LeUnIntTest extends LeroysBacksideUnitTestAbstract
{
    public function testLeUnInt()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeUnInt::getMin(), LeUnInt::getMax());
        }
        $i = 0;
        foreach ($values as $value) {
            try {
                $number = LeUnInt::set($value);
                $this->assertInstanceOf('LeroysBackside\LeType\LeUnInt', $number);
                $this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                if (2 >= $i) {
                    $this->assertEquals("{$value} is not numeric", $e->getMessage());
                } else {
                    $this->assertEquals("{$value} cannot be greater than " . LeUnInt::getMax(), $e->getMessage());
                }
            }
            $i++;
        }
    }

    public function testLeUnIntValidate()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        foreach ($values as $value) {
            $number = LeUnInt::verify($value);
            $this->assertFalse($number);
        }
        $values = [];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeUnInt::getMin(), LeUnInt::getMax());
        }
        foreach ($values as $value) {
            $number = LeUnInt::verify($value);
            $this->assertInstanceOf('LeroysBackside\LeType\LeUnInt', $number);
        }
    }
}
