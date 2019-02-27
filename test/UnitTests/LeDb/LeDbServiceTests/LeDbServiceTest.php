<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 2/25/2019
 * Time: 10:07 AM
 */

namespace LeroyTest\LeDb\LeDbServiceTests;

require_once dirname(__FILE__, 5) . '/src/bootstrap.php';

use Leroy\LeDb\LeDbService;
use LeroyTestLib\LeroyUnitTestAbstract;
use PHPUnit\Framework\TestCase;

class LeDbServiceTest extends LeroyUnitTestAbstract
{
    public function testDuplicateKeyWithNoFlag()
    {
        $db = LeDbService::init('leroy', DBCONFIGFILE1);
        $db->execute('TRUNCATE TABLE unique_key;');
        $sql = "INSERT INTO unique_key (unique_key_value_1, unique_key_value_2) VALUES (1, 1);";
        $result = $db->execute($sql);
        $this->assertInstanceOf('LeDbResultInterface', $result);
        echo __FILE__ . ' ' . __LINE__ . ' $result:<pre>' . print_r($result, true) . '</pre>';
    }
}
