<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 9:48 PM
 */

namespace LeroysBacksideTest\LeType;

use Exception;
use LeroysBackside\LeType\LeInt;
use LeroysBacksideTestLib\LeroysBacksideUnitTestAbstract;

class LeIntTest extends LeroysBacksideUnitTestAbstract
{
    public function testLeInt()
    {
        $values = ['string', 'test', 'leint'];
        $max = rand(20, 30);
        for ($i = 0; $i < $max; $i++) {
            $values[] = rand(-2147483648, 2147483647);
        }
        echo __METHOD__ . ' $values: ' . print_r($values, true) . PHP_EOL;
        foreach ($values as $value) {
            try {
                $number = LeInt::init($value);
               // $this->assertInstanceOf('LeroysBackside\LeType\LeInt', $number);
                //$this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                $this->assertEquals("{$value} is not numeric", $e->getMessage());
            }
        }
    }
}
