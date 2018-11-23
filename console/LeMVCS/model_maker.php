<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 11/21/2018
 * Time: 12:40 PM
 *
 * @var string $host
 * @var string $db_name
 * @var string $port
 * @var string $table_name
 * @var string $user_name
 * @var string $password
 * @var string $destination_path
 */

use LeroyConsole\LeMVCS\ModelMaker;

require_once dirname(__FILE__, 2) . '/console_master.php';

function help()
{
    return "
        destination_path\t
        host\t
        db_name\t
        port\t
        table_name\t
        user_name\t
        password\t
    \n";
}

try {
    $modelMaker = new ModelMaker(__DIR__);
    $modelMaker->gatherData();
    if ($file_name = $modelMaker->create()) {
        echo "The file \"{$file_name}\" is ready!\n";
    }
} catch (Exception $e) {
    echo 'Exception: ' . $e->getMessage() . PHP_EOL;
}
