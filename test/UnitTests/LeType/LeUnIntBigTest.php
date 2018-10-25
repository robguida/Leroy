<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/12/2018
 * Time: 9:01 PM
 */

namespace LeroyTest\LetType;

use Exception;
use Leroy\LeType\LeUnIntBig;
use LeroyTestLib\LeroyUnitTestAbstract;

class LeUnIntBigTest extends LeroyUnitTestAbstract
{
    public function testLeUnIntBig()
    {
        $values = ['string', 'test', 'leintbig', pow(2, 63)];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeUnIntBig::getMin(), LeUnIntBig::getMax());
        }
        foreach ($values as $value) {
            try {
                $number = LeUnIntBig::set($value);
                $this->assertInstanceOf('Leroy\LeType\LeUnIntBig', $number);
                $this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                $this->assertEquals("{$value} is not numeric", $e->getMessage());
            }
        }
    }

    public function testLeUnIntBigValidate()
    {
        $values = ['string', 'test', 'leintbig', pow(2, 63)];
        foreach ($values as $value) {
            $number = LeUnIntBig::verify($value);
            $this->assertFalse($number);
        }
        $values = [];
        for ($i = 0; $i < 10; $i++) {
            $values[] = rand(LeUnIntBig::getMin(), LeUnIntBig::getMax());
        }
        foreach ($values as $value) {
            $number = LeUnIntBig::verify($value);
            $this->assertInstanceOf('Leroy\LeType\LeUnIntBig', $number);
        }
    }
}
