<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 5/13/2019
 * Time: 9:53 AM
 */

namespace LeroyTest\LeDb\LeDbServiceTests;

require_once '/var/www/Leroy/src/bootstrap.php';

use LeroyTestLib\LeroyUnitTestAbstract;

class LeDbResultTest extends LeroyUnitTestAbstract
{
    public function testGetFirstValueIsNullWhenSqlFails()
    {
        $this->truncateTables();
        $sql = "INSERT INTO address (address_1, city, state)
                VALUES ('1888 address', 'big city', 'GA');";
        $result = $this->db->execute($sql);
        $this->assertNull($result->getFirstValue());
        $this->assertNotEmpty($result->getErrorInfo());
        $this->assertEquals('HY000', $result->getErrorCode());
        $this->assertEquals(
            'SQLSTATE[HY000]: General error: 1364 Field \'modified_by_id\' doesn\'t have a default value',
            $result->getErrorInfo()
        );
    }
}
