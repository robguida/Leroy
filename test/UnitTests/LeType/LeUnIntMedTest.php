<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 9:48 PM
 */

namespace LeroyTest\LeType;

use Exception;
use Leroy\LeType\LeUnIntMed;
use LeroyTestLib\LeroyUnitTestAbstract;

class LeUnIntMedTest extends LeroyUnitTestAbstract
{
    public function testLeUnIntMed()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeUnIntMed::getMin(), LeUnIntMed::getMax());
        }
        $i = 0;
        foreach ($values as $value) {
            try {
                $number = LeUnIntMed::set($value);
                $this->assertInstanceOf('Leroy\LeType\LeUnIntMed', $number);
                $this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                if (2 >= $i) {
                    $this->assertEquals("{$value} is not numeric", $e->getMessage());
                } else {
                    $this->assertEquals("{$value} cannot be greater than " . LeUnIntMed::getMax(), $e->getMessage());
                }
            }
            $i++;
        }
    }

    public function testLeUnIntMedValidate()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        foreach ($values as $value) {
            $number = LeUnIntMed::verify($value);
            $this->assertFalse($number);
        }
        $values = [];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeUnIntMed::getMin(), LeUnIntMed::getMax());
        }
        foreach ($values as $value) {
            $number = LeUnIntMed::verify($value);
            $this->assertInstanceOf('Leroy\LeType\LeUnIntMed', $number);
        }
    }
}
