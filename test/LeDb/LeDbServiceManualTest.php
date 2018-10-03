<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 9/25/2018
 * Time: 11:48 PM
 */
require_once '../../vendor/autoload.php';

use LeroysBackside\LeDb\LeDbService;

try {
    $db = new LeDbService(
        '/var/www/LeroysBackside/test/LeDb/db_settings/dev.robguida.com.json',
        'leroysbackside'
    );
    $result = $db->execute("INSERT INTO contact (first_name, last_name) VALUES ('rob', 'guida');");
    $result2 = $db->execute("SELECT * FROM contact;");
    $sql = 'INSERT INTO contact (first_name, last_name) VALUES (?, ?);';
    $r3 = $db->execute($sql, ['john', 'doe']);
    $r4 = $db->execute($sql, ['jane', 'doey']);
    $sql = 'INSERT INTO contact (first_name, last_name) VALUES (:fname, :lname);';
    $r3 = $db->execute($sql, ['fname' => 'johnhy', 'lname' => 'doehtry']);
    $r4 = $db->execute($sql, ['fname' => 'janey', 'lname' => 'doeygirl']);
    echo __LINE__ . ' ' . print_r($r3, true);
    echo __LINE__ . ' ' . print_r($r4, true);
} catch (Exception $e) {
    print_r($e);
}

