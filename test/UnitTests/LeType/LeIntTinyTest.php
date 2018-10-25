<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 9:48 PM
 */

namespace LeroyTest\LeType;

use Exception;
use Leroy\LeType\LeIntTiny;
use LeroyTestLib\LeroyUnitTestAbstract;

class LeIntTinyTest extends LeroyUnitTestAbstract
{
    public function testLeIntTiny()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeIntTiny::getMin(), LeIntTiny::getMax());
        }
        $i = 0;
        foreach ($values as $value) {
            try {
                $number = LeIntTiny::set($value);
                $this->assertInstanceOf('Leroy\LeType\LeIntTiny', $number);
                $this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                if (2 >= $i) {
                    $this->assertEquals("{$value} is not numeric", $e->getMessage());
                } else {
                    $this->assertEquals("{$value} cannot be greater than " . LeIntTiny::getMax(), $e->getMessage());
                }
            }
            $i++;
        }
    }

    public function testLeIntTinyValidate()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        foreach ($values as $value) {
            $number = LeIntTiny::verify($value);
            $this->assertFalse($number);
        }
        $values = [];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeIntTiny::getMin(), LeIntTiny::getMax());
        }
        foreach ($values as $value) {
            $number = LeIntTiny::verify($value);
            $this->assertInstanceOf('Leroy\LeType\LeIntTiny', $number);
        }
    }
}
