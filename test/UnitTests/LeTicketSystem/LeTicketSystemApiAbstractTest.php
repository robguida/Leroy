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

class LeTicketSystemApiAbstractTest extends TestCase
{
    public function testConvertArrayIntoTicketBody()
    {

    }
}

class LeTicketSystemApi extends LeTicketSystemApiAbstract
{
    public function testConvertArrayIntoTicketBody(LeTicketSystemRequestModel $model)
    {

    }
}