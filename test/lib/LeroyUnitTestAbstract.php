<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/7/2018
 * Time: 12:37 AM
 */

namespace LeroyTestLib;

use Leroy\LeDb\LeDbService;
use PHPUnit\Framework\TestCase;

require_once dirname(__FILE__, 3) . '/src/bootstrap.php';

abstract class LeroyUnitTestAbstract extends TestCase
{
    protected $db;

    protected function setUp()
    {
        $this->db = LeDbService::init('leroy', DBCONFIGFILE1);
        $this->db->execute('TRUNCATE TABLE address;');
        $this->db->execute('TRUNCATE TABLE contact;');
    }

    protected function getDataForContactNotAssociated()
    {
        return [
            ['doe', 'jane'],
            ['doe1', 'jane'],
            ['doe2', 'jane'],
            ['doe3', 'jane'],
            ['doe1', 'john'],
            ['doe2', 'jimmy'],
            ['doe3', 'joey'],
            ['doe4', 'james'],
            ['doe5', 'jeffrey'],
            ['doe6', 'jean'],
        ];
    }
}
