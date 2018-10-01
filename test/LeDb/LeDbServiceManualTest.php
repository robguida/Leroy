<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 9/25/2018
 * Time: 11:48 PM
 */
require_once '/var/www/LeroysBackside/src/bootstrap.php';

use LeroysBackside\LeDb\LeDbService;

$db = new LeDbService(
    '/var/www/LeroysBackside/test/LeDb/db_settings/dev.robguida.com.json',
    'leroysbackside'
);
$result = $db->execute("INSERT INTO contact (first_name, last_name) VALUES ('rob', 'guida');");
echo __FILE__ . ' ' . __LINE__ . ' ' . print_r($result, true);
$result = $db->execute("SELECT * FROM contact;");
echo __FILE__ . ' ' . __LINE__ . ' ' . print_r($result, true);

