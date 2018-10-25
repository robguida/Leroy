<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 9:48 PM
 */

namespace LeroyTest\LeType;

use Exception;
use Leroy\LeType\LeUnIntTiny;
use LeroyTestLib\LeroyUnitTestAbstract;

class LeUnIntTinyTest extends LeroyUnitTestAbstract
{
    public function testLeUnIntTiny()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeUnIntTiny::getMin(), LeUnIntTiny::getMax());
        }
        $i = 0;
        foreach ($values as $value) {
            try {
                $number = LeUnIntTiny::set($value);
                $this->assertInstanceOf('Leroy\LeType\LeUnIntTiny', $number);
                $this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                if (2 >= $i) {
                    $this->assertEquals("{$value} is not numeric", $e->getMessage());
                } else {
                    $this->assertEquals("{$value} cannot be greater than " . LeUnIntTiny::getMax(), $e->getMessage());
                }
            }
            $i++;
        }
    }

    public function testLeUnIntTinyValidate()
    {
        $values = ['string', 'test', 'leint', pow(2, 63)];
        foreach ($values as $value) {
            $number = LeUnIntTiny::verify($value);
            $this->assertFalse($number);
        }
        $values = [];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeUnIntTiny::getMin(), LeUnIntTiny::getMax());
        }
        foreach ($values as $value) {
            $number = LeUnIntTiny::verify($value);
            $this->assertInstanceOf('Leroy\LeType\LeUnIntTiny', $number);
        }
    }
}
