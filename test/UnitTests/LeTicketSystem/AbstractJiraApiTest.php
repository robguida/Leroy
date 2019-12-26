<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/26/2019
 * Time: 6:18 AM
 */

require '/var/www/Leroy/src/bootstrap.php';
use Leroy\LeTicketSystem\LeTicketSystemFactory;

echo '<h1>' . __FILE__ . '</h1>';
$ts = LeTicketSystemFactory::init(LeTicketSystemFactory::TS_JIRA);
echo __FILE__ . ' ' . __LINE__ . ' $ts:<pre style="text-align: left;">' . print_r($ts, true) . '</pre>';
