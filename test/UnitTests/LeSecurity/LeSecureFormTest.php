<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 11/27/2018
 * Time: 10:56 PM
 *
 */

namespace LeroyTest\LeSecurity;

require_once '/var/www/Leroy/src/bootstrap.php';

use Leroy\LeSecurity\LeSecureForm;
use LeroyTestLib\LeroyUnitTestAbstract;

/**
 * Class LeApiResponseModelTest
 * @package LeroyTest\LeApi
 */
class LeSecureFormTest extends LeroyUnitTestAbstract
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testGetToken()
    {
        $this->markTestIncomplete('Not fleshed out yet');
        $secureForm = new LeSecureForm();
        $secureForm->getToken(600);
    }
}
