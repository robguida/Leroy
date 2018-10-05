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
    /* Test the different variations of LeDbService */
    foreach (['leroysbackside', 'leroysbackside2'] as $dsn) {
        $db = LeDbService::init($dsn, DBCONFIGFILE1);
        if ('leroysbackside' == $dsn) {
            $result1 = $db->execute('TRUNCATE TABLE contact;');
            $result1 = $db->execute('INSERT INTO contact (first_name, last_name) VALUES ("John", "Doe");');
            $result2 = $db->execute('SELECT COUNT(*) as cnt FROM contact;');
        } else {
            $result1 = $db->execute('TRUNCATE TABLE address;');
            $result1 = $db->execute(
                'INSERT INTO address (address_1, city, state)
                VALUES ("912 Feist Ave", "Pottstown", "PA");'
            );
            $result2 = $db->execute('SELECT COUNT(*) as cnt FROM address;');
        }
        echo "Testing: {$dsn}\n";
        print_r($db);
        print_r($result1);
        echo "Get First Value = {$result2->getFirstValue()}\n";
    }

} catch (Exception $e) {
    print_r($e);
}

