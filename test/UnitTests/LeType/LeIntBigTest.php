<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/12/2018
 * Time: 9:01 PM
 */

namespace LeroyTest\LetType;

use Exception;
use Leroy\LeType\LeIntBig;
use LeroyTestLib\LeroyUnitTestAbstract;

class LeIntBigTest extends LeroyUnitTestAbstract
{
    public function testLeIntBig()
    {
        $values = ['string', 'test', 'leintbig', pow(2, 63)];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeIntBig::getMin(), LeIntBig::getMax());
        }
        foreach ($values as $value) {
            try {
                $number = LeIntBig::set($value);
                $this->assertInstanceOf('Leroy\LeType\LeIntBig', $number);
                $this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                $this->assertEquals("{$value} is not numeric", $e->getMessage());
            }
        }
    }

    public function testLeIntBigValidate()
    {
        $values = ['string', 'test', 'leintbig', pow(2, 63)];
        foreach ($values as $value) {
            $number = LeIntBig::verify($value);
            $this->assertFalse($number);
        }
        $values = [];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeIntBig::getMin(), LeIntBig::getMax());
        }
        foreach ($values as $value) {
            $number = LeIntBig::verify($value);
            $this->assertInstanceOf('Leroy\LeType\LeIntBig', $number);
        }
    }
}
