<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 9:48 PM
 */

namespace LeroyTest\LeType;

use Exception;
use Leroy\LeType\LeIntSmall;
use LeroyTestLib\LeroyUnitTestAbstract;

class LeIntSmallTest extends LeroyUnitTestAbstract
{
    public function testLeIntSmall()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeIntSmall::getMin(), LeIntSmall::getMax());
        }
        $i = 0;
        foreach ($values as $value) {
            try {
                $number = LeIntSmall::set($value);
                $this->assertInstanceOf('Leroy\LeType\LeIntSmall', $number);
                $this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                if (2 >= $i) {
                    $this->assertEquals("{$value} is not numeric", $e->getMessage());
                } else {
                    $this->assertEquals("{$value} cannot be greater than " . LeIntSmall::getMax(), $e->getMessage());
                }
            }
            $i++;
        }
    }

    public function testLeIntSmallValidate()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        foreach ($values as $value) {
            $number = LeIntSmall::verify($value);
            $this->assertFalse($number);
        }
        $values = [];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeIntSmall::getMin(), LeIntSmall::getMax());
        }
        foreach ($values as $value) {
            $number = LeIntSmall::verify($value);
            $this->assertInstanceOf('Leroy\LeType\LeIntSmall', $number);
        }
    }
}
