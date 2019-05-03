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
    /* in a www setting, this would be from the root of the site */
    private $file = '/tmp/testGetScriptTag.js';
    /* in a www setting, this would be the full path on the drive */
    private $full_path = '/tmp/testGetScriptTag.js';

    public function setUp()
    {
        parent::setUp();
        $oF = fopen($this->file, 'w+');
        fclose($oF);
    }

    public function tearDown()
    {
        parent::tearDown();
        unlink($this->file);
    }

    public function testBasicFileMTimeFunctionality()
    {
        $time = filemtime($this->file);
        $this->assertGreaterThan(0, $time);
        /* cannot have a querystring when using filemtime() */
        $time2 = @filemtime($this->file . '?testwithparam=');
        $this->assertEmpty($time2);
    }

    public function testGetLinkTag()
    {
        $leViewTools = new LeViewTools();
        $string = $leViewTools->getScriptTag($this->file, $this->full_path);
        preg_match('/(^[<script].*[\=])([\d]+)(.*)/', $string, $matches);
        $this->assertNotEmpty($string);
        $this->assertGreaterThan(0, count($matches));
        $this->assertEquals('<script type="application/javascript" src="' . $this->file . '?r=', $matches[1]);
        $this->assertGreaterThan(0, $matches[2]);
        $this->assertEquals('"></script>', $matches[3]);
    }

    public function testGetLinkTagWithQueryString()
    {
        $leViewTools = new LeViewTools();
        $file = "{$this->file}?test=leroybrown";
        $full_path = "{$this->full_path}?test=leroybrown";
        $string = $leViewTools->getScriptTag($file, $full_path);
        preg_match('/(^[<script].*[\=])([\d]+)(.*)/', $string, $matches);
        $this->assertNotEmpty($string);
        $this->assertGreaterThan(0, count($matches));
        $this->assertEquals(
            '<script type="application/javascript" src="' . $this->file . '?test=leroybrown&r=',
            $matches[1]
        );
        $this->assertGreaterThan(0, $matches[2]);
        $this->assertEquals('"></script>', $matches[3]);
    }
}
