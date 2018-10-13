<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 9:48 PM
 */

namespace LeroysBacksideTest\LeType;

use Exception;
use LeroysBackside\LeType\LeIntMed;
use LeroysBacksideTestLib\LeroysBacksideUnitTestAbstract;

class LeIntMedTest extends LeroysBacksideUnitTestAbstract
{
    public function testLeIntMed()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeIntMed::getMin(), LeIntMed::getMax());
        }
        $i = 0;
        foreach ($values as $value) {
            try {
                $number = LeIntMed::set($value);
                $this->assertInstanceOf('LeroysBackside\LeType\LeIntMed', $number);
                $this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                if (2 >= $i) {
                    $this->assertEquals("{$value} is not numeric", $e->getMessage());
                } else {
                    $this->assertEquals("{$value} cannot be greater than " . LeIntMed::getMax(), $e->getMessage());
                }
            }
            $i++;
        }
    }

    public function testLeIntMedValidate()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        foreach ($values as $value) {
            $number = LeIntMed::verify($value);
            $this->assertFalse($number);
        }
        $values = [];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeIntMed::getMin(), LeIntMed::getMax());
        }
        foreach ($values as $value) {
            $number = LeIntMed::verify($value);
            $this->assertInstanceOf('LeroysBackside\LeType\LeIntMed', $number);
        }
    }
}
