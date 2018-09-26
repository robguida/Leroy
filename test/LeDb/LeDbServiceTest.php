<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 9/25/2018
 * Time: 11:48 PM
 */
require_once '../../src/bootstrap.php';

use LeroysBackside\LeDb\LeDbService;

$db = LeDbService::init('test');
$result = $db->execute('SELECT * FROM test');
echo '<pre>' . print_r($db, true) . '</pre>';
echo '<pre>' . print_r($result, true) . '</pre>';
echo $result->getException()->getMessage();
