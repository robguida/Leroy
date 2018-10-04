<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 9/25/2018
 * Time: 11:48 PM
 */
require_once '../../src/bootstrap.php';

use LeroysBackside\LeDb\LeDbService;

try {
    $db = LeDbService::init(
        '/var/www/LeroysBackside/test/LeDb/db_settings/dev.robguida.com.json',
        'leroysbackside'
    );
    $r = $db->execute('SELECT * FROM contact;');
    print_r($r);
    print_r($r->fetchAssoc());

} catch (Exception $e) {
    print_r($e);
}

