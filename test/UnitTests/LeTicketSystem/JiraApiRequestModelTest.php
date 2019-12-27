<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/27/2019
 * Time: 3:27 PM
 */
namespace LeroyTest\LeTicketSystem;

require_once '/var/www/Leroy/src/bootstrap.php';

use Leroy\LeTicketSystem\Vendor\JiraApiRequestModel;
use LeroyTestLib\LeroyUnitTestAbstract;

class JiraApiRequestModelTest extends LeroyUnitTestAbstract
{
    public function testJirApiRequestModelInstantiationWithDescriptionAsAnArray()
    {
        $model = new JiraApiRequestModel();
        $title = 'Model Test 1';
        $description = ['key1' => 'test1', 'key2' => 'test2'];
        $project = 'Project Name';
        $priority = 'high';
        $bug = 'bug';
        $this->assertInstanceOf('Leroy\LeTicketSystem\LeTicketSystemRequestModel', $model);
        $this->assertInstanceOf('Leroy\LeTicketSystem\Vendor\JiraApiRequestModel', $model);
        $model->setProject($project);
        $model->setTitle($title);
        $model->setDescription($description);
        $model->setPriority($priority);
        $model->setTicketType($bug);
        $this->assertEquals($project, $model->getProject());
        $this->assertEquals($title, $model->getTitle());
        $this->assertEquals($description, $model->getDescription());
        $this->assertEquals($priority, $model->getPriority());
        $this->assertEquals($bug, $model->getTicketType());
    }

    public function testJirApiRequestModelInstantiationWithDescriptionAString()
    {
        $model = new JiraApiRequestModel();
        $title = 'Model Test 1';
        $description = 'Description Test';
        $project = 'Project Name';
        $priority = 'high';
        $bug = 'bug';
        $this->assertInstanceOf('Leroy\LeTicketSystem\LeTicketSystemRequestModel', $model);
        $this->assertInstanceOf('Leroy\LeTicketSystem\Vendor\JiraApiRequestModel', $model);
        $model->setProject($project);
        $model->setTitle($title);
        $model->setDescription($description);
        $model->setPriority($priority);
        $model->setTicketType($bug);
        $this->assertEquals($project, $model->getProject());
        $this->assertEquals($title, $model->getTitle());
        $this->assertEquals($description, $model->getDescription());
        $this->assertEquals($priority, $model->getPriority());
        $this->assertEquals($bug, $model->getTicketType());
    }
}
