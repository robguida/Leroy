<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 12/27/2019
 * Time: 5:26 PM
 */
namespace LeroyTest\LeTicketSystem;

require_once '/var/www/Leroy/src/bootstrap.php';

use Leroy\LeTicketSystem\Vendor\JiraApi;
use Leroy\LeTicketSystem\Vendor\JiraApiRequestModel;
use LeroyTestLib\LeroyUnitTestAbstract;

class JiraApiTest extends LeroyUnitTestAbstract
{
    public function testCreateTicketReturnsLeApiResponseModelWithStdClass()
    {
        $model = new JiraApiRequestModel();
        $model->setProject('DEVENV');
        $model->setTitle('Title Test');
        $model->setDescription(['Test' => 'Description Test']);
        $model->setPriority('High');
        $model->setTicketType('Bug');
        $model->setPathToCredentials('/var/www/PharmPay/UI/');
        $api = new JiraApi();
        $result = $api->create($model);
        $data = $result->getData();
        $this->assertInstanceOf('Leroy\LeApi\LeApiResponseModel', $result);
        $this->assertTrue($result->isSuccessful());
        $this->assertTrue(0 === strpos($data[0], 'DEVENV'));
    }
}
