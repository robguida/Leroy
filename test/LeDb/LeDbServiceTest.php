<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 9/25/2018
 * Time: 11:48 PM
 */
require_once '../../src/bootstrap.php';

use LeroysBackside\LeDb\LeDbService;

$db = new LeDbService('dev.robguida.com.json', 'pharmpay');
$result = $db->execute('SELECT * FROM invoice;');

