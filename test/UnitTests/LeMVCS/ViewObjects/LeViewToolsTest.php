<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 11/10/2018
 * Time: 11:04 AM
 */

namespace Leroy\LeMVCS\ViewObjects;

use LeroyTestLib\LeroyUnitTestAbstract;

require_once '/var/www/Leroy/src/bootstrap.php';

class LeViewToolsTest extends LeroyUnitTestAbstract
{
    public function testGetScriptTag()
    {
        $this->markTestIncomplete('Not fleshed out yet');
        $file = '/tmp/testGetScriptTag.csv';
        $oF = fopen($file, 'w+');
        fclose($oF);

    }
}
