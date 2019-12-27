<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/27/2019
 * Time: 3:00 PM
 */
namespace LeroyTest\LeTicketSystem;

require_once '/var/www/Leroy/src/bootstrap.php';

use Leroy\LeTicketSystem\LeTicketSystemRequestModel;
use LeroyTestLib\LeroyUnitTestAbstract;

class LeTicketSystemRequestModelTest extends LeroyUnitTestAbstract
{
    public function testTicketSystemRequestModelInstantiation()
    {
        $model = new LeTicketSystemRequestModel();
        $title = 'Model Test 1';
        $description = ['key1' => 'test1', 'key2' => 'test2'];
        $priority = 'high';
        $bug = 'bug';
        $this->assertInstanceOf('Leroy\LeTicketSystem\LeTicketSystemRequestModel', $model);
        $model->setTitle('Model Test 1');
        $model->setDescription($description);
        $model->setPriority($priority);
        $model->setTicketType($bug);
        $this->assertEquals($title, $model->getTitle());
        $this->assertEquals($description, $model->getDescription());
        $this->assertEquals($priority, $model->getPriority());
        $this->assertEquals($bug, $model->getTicketType());
    }
}
