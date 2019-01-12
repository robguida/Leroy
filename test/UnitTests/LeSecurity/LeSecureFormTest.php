<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 11/27/2018
 * Time: 10:56 PM
 *
 */

namespace LeroyTest\LeApi;

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
        $secureForm = new LeSecureForm();
        $secureForm->getToken(600);
    }
}
