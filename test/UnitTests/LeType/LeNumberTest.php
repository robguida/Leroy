<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/11/2018
 * Time: 9:31 PM
 */

namespace LeroyTest\LeType;

require_once '/var/www/Leroy/src/bootstrap.php';

use Exception;
use InvalidArgumentException;
use Leroy\LeType\LeInt;
use Leroy\LeType\LeNumber;
use Leroy\LeType\LeUnInt;
use LeroyTestLib\LeroyUnitTestAbstract;

class LeNumberTest extends LeroyUnitTestAbstract
{
    public function testGetBinaries()
    {
        $number = LeInt::init(9);
        $result = $number->getBinaries();
        $this->assertEquals([8, 1], $result);

        $number = LeInt::init(26);
        $result = $number->getBinaries();
        $this->assertEquals([16, 8, 2], $result);

        $number = LeInt::init(44);
        $result = $number->getBinaries();
        $this->assertEquals([32, 8, 4], $result);

        $number = LeInt::init(87);
        $result = $number->getBinaries();
        $this->assertEquals([64, 16, 4, 2, 1], $result);

        $number = LeInt::init(379);
        $result = $number->getBinaries();
        $this->assertEquals([256, 64, 32, 16, 8, 2, 1], $result);

        $number = LeInt::init(7843);
        $result = $number->getBinaries();
        $this->assertEquals([4096, 2048, 1024, 512, 128, 32, 2, 1], $result);

        $number = LeInt::init(78437);
        $result = $number->getBinaries();
        $this->assertEquals([65536, 8192, 4096, 512, 64, 32, 4, 1], $result);

        $number = LeInt::init(589361);
        $result = $number->getBinaries();
        $this->assertEquals([524288, 32768, 16384, 8192, 4096, 2048, 1024, 512, 32, 16, 1], $result);

        $number = LeInt::init(7985693);
        $result = $number->getBinaries();
        $this->assertEquals(
            [4194304, 2097152, 1048576, 524288, 65536, 32768, 16384, 4096, 2048, 512, 16, 8, 4, 1],
            $result
        );

        $number = LeUnInt::init(999999999999999999);
        $result = $number->getBinaries();
        $this->assertEquals($this->getBinariesFromMaxNumber(), $result);
    }

    public function testGetBinariesStatic()
    {
        $result = LeInt::getBinaryFromNumber(44);
        $this->assertEquals([32, 8, 4], $result);
    }

    public function testNumericType()
    {
        $values = ['test', LeNumber::getMin(), LeNumber::getMax(), 'string'];
        foreach ($values as $value) {
            try {
                $number = LeNumber::init($value);
                $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
                $this->assertEquals($value, $number->get());
            } catch (Exception $e) {
                $this->assertEquals("{$value} is not numeric", $e->getMessage());
            }
        }
    }

    public function testMinMaxNumberic()
    {
        $number = LeNumber::init(20, 19, 20);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        $number = LeNumber::init(20, 19, 21);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        $number = LeNumber::init(20, 20, 20);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        $number = LeNumber::init(20, 20, 21);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMinNumericFailed()
    {
        LeNumber::init(20, 21);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMaxNumericFailed()
    {
        LeNumber::init(20, 1, 19);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUnSignedNumeric()
    {
        $number = LeNumber::init(1, null, null, false);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        LeNumber::init(-1, null, null, false);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSignedNumeric()
    {
        $number = LeNumber::init(-1, null, null, true);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        $this->assertTrue($number->isSigned());
        LeNumber::init(-1, null, null, false);
    }

    public function testPrecision()
    {
        $number = LeNumber::init(123.456, null, null, null, 2);
        $this->assertInstanceOf('Leroy\LeType\LeNumber', $number);
        $this->assertEquals(123.46, $number->get());
        $this->assertEquals(2, $number->getPrecision());
    }

    private function getBinariesFromMaxNumber()
    {
        return [
            576460752303423488,
            288230376151711744,
            72057594037927936,
            36028797018963968,
            18014398509481984,
            9007199254740992,
            140737488355328,
            35184372088832,
            17592186044416,
            4398046511104,
            2199023255552,
            549755813888,
            137438953472,
            68719476736,
            8589934592,
            4294967296,
            2147483648,
            536870912,
            67108864,
            33554432,
            16777216,
            4194304,
            2097152,
            131072,
            65536,
            32768,
            16384,
            8192,
            4096,
            2048,
            1024,
            512,
            256,
            128,
            64,
            32,
            16,
            8,
            4,
            2,
            1,
        ];
    }
}
