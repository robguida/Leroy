<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/27/2019
 * Time: 2:31 PM
 */

namespace LeroyTest\LeTicketSystem;

require_once '/var/www/Leroy/src/bootstrap.php';

use Leroy\LeTicketSystem\LeTicketSystemApiAbstract;

use Leroy\LeTicketSystem\LeTicketSystemRequestModel;
use PHPUnit\Framework\TestCase;

/**
 * Class LeTicketSystemApiAbstractTest
 * @package LeroyTest\LeTicketSystem
 */
class LeTicketSystemApiAbstractTest extends TestCase
{
    public function testConvertArrayIntoTicketBody()
    {
        $model = new LeTicketSystemRequestModel();
        $model->setDescription(
            [
                'Test 1' => [
                    'Test 1.a' => 'String 1.a',
                    'Test 1.b' => ['Test 1.b.1' => 'String 1.b.1', 'Test 1.b.2' => 'String 1.b.2'],
                    'Test 1.c' => [
                        'Test 1.c.1' => ['Test 1.c.1.a' => 'String 1.c.1.a', 'Test 1.c.1.b' => 'String 1.c.1.b'],
                        'Test 1.c.2' => ['Test 1.c.2.a' => 'String 1.c.2.a', 'Test 1.c.2.b' => 'String 1.c.2.b'],
                    ]
                ],
                'Test 2' => [
                    'Test 2.a' => 'String 2.a',
                    'Test 2.b' => 'String 2.b',
                    'Test 2.c' => 'String 2.c',
                    'Test 2.d' => ['Test 2.d.1' => 'String 2.d.1', 'Test 2.d.2' => 'String 2.d.2'],
                    'Test 2.e' => [
                        'Test 2.e.1' => ['Test 2.e.1.a' => 'String 2.e.1.a', 'Test 2.e.1.b' => 'String 2.e.1.b'],
                        'Test 2.e.2' => ['Test 2.e.2.a' => 'String 2.e.2.a', 'Test 2.e.2.b' => 'String 2.e.2.b'],
                        'Test 2.e.3' => ['Test 2.e.3.a' => 'String 2.e.3.a', 'Test 2.e.3.b' => 'String 2.e.3.b'],
                    ]
                ],
                'Test 3' => [
                    'Test 3.a' => 'String 3.a',
                    'Test 3.b' => 'String 3.b',
                    'Test 3.c' => 'String 3.c',
                    'Test 3.d' => ['Test 3.d.1' => 'String 3.d.1', 'Test 3.d.2' => 'String 3.d.2'],
                    'Test 3.e' => [
                        'Test 3.e.1' => ['Test 3.e.1.a' => 'String 3.e.1.a', 'Test 3.e.1.b' => 'String 3.e.1.b'],
                        'Test 3.e.2' => ['Test 3.e.2.a' => 'String 3.e.2.a', 'Test 3.e.2.b' => 'String 3.e.2.b'],
                        'Test 3.e.3' => ['Test 3.e.3.a' => 'String 3.e.3.a', 'Test 3.e.3.b' => 'String 3.e.3.b'],
                    ]
                ]
            ]
        );
        $testApi = new LeTicketSystemApi();
        $result = $testApi->testConvertArrayIntoTicketBody($model);
        $this->assertTrue(is_string($result));
        $lines = explode("\n", $result);
        $i = 0;
        foreach ($lines as $line) {
            $this->assertEquals($line, $this->array[$i++]);
        }
    }

    private $array = [
        'h1. Test 1',
        '* Test 1.a = String 1.a',
        '* Test 1.b',
        '** Test 1.b.1 = String 1.b.1',
        '** Test 1.b.2 = String 1.b.2',
        '* Test 1.c',
        '** Test 1.c.1',
        '*** Test 1.c.1.a = String 1.c.1.a',
        '*** Test 1.c.1.b = String 1.c.1.b',
        '** Test 1.c.2',
        '*** Test 1.c.2.a = String 1.c.2.a',
        '*** Test 1.c.2.b = String 1.c.2.b',
        'h1. Test 2',
        '* Test 2.a = String 2.a',
        '* Test 2.b = String 2.b',
        '* Test 2.c = String 2.c',
        '* Test 2.d',
        '** Test 2.d.1 = String 2.d.1',
        '** Test 2.d.2 = String 2.d.2',
        '* Test 2.e',
        '** Test 2.e.1',
        '*** Test 2.e.1.a = String 2.e.1.a',
        '*** Test 2.e.1.b = String 2.e.1.b',
        '** Test 2.e.2',
        '*** Test 2.e.2.a = String 2.e.2.a',
        '*** Test 2.e.2.b = String 2.e.2.b',
        '** Test 2.e.3',
        '*** Test 2.e.3.a = String 2.e.3.a',
        '*** Test 2.e.3.b = String 2.e.3.b',
        'h1. Test 3',
        '* Test 3.a = String 3.a',
        '* Test 3.b = String 3.b',
        '* Test 3.c = String 3.c',
        '* Test 3.d',
        '** Test 3.d.1 = String 3.d.1',
        '** Test 3.d.2 = String 3.d.2',
        '* Test 3.e',
        '** Test 3.e.1',
        '*** Test 3.e.1.a = String 3.e.1.a',
        '*** Test 3.e.1.b = String 3.e.1.b',
        '** Test 3.e.2',
        '*** Test 3.e.2.a = String 3.e.2.a',
        '*** Test 3.e.2.b = String 3.e.2.b',
        '** Test 3.e.3',
        '*** Test 3.e.3.a = String 3.e.3.a',
        '*** Test 3.e.3.b = String 3.e.3.b',
    ];
}

/**
 * Class LeTicketSystemApi
 * @package LeroyTest\LeTicketSystem
 */
class LeTicketSystemApi extends LeTicketSystemApiAbstract
{
    public function __construct()
    {
        $this->prefix_values = ['h1.', '*'];
    }

    /**
     * @param LeTicketSystemRequestModel $model
     * @return string
     */
    public function testConvertArrayIntoTicketBody(LeTicketSystemRequestModel $model)
    {
        return parent::convertDescriptionIntoTicketBody($model->getDescription());
    }
}
