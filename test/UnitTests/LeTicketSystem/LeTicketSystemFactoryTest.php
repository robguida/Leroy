<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/27/2019
 * Time: 2:38 PM
 */

require_once '/var/www/Leroy/src/bootstrap.php';

use Leroy\LeTicketSystem\LeTicketSystemFactory;
use Leroy\LeTicketSystem\LeTicketSystemInterface;
use LeroyTestLib\LeroyUnitTestAbstract;


class LeTicketSystemFactoryTest extends LeroyUnitTestAbstract
{
    public function testInstantiateJira()
    {
        $ts = LeTicketSystemFactory::init(LeTicketSystemFactory::TS_JIRA);
        $this->assertInstanceOf('Leroy\LeTicketSystem\LeTicketSystemInterface', $ts);
        $this->assertInstanceOf('Leroy\LeTicketSystem\Vendor\JiraApi', $ts);
    }
}
