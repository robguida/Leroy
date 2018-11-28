<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 11/27/2018
 * Time: 10:56 PM
 *
 */

namespace LeroyTest\LeApi;

use Exception;
use Leroy\LeApi\LeApiResponseModel;
use LeroyTestLib\LeroyUnitTestAbstract;

/**
 * Class LeApiResponseModelTest
 * @package LeroyTest\LeApi
 */
class LeApiResponseModelTest extends LeroyUnitTestAbstract
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testSuccessfulObjectCreation()
    {
        $data = ['first_five_numbers' => [1, 2, 3, 4, 5]];
        $r = new LeApiResponseModel();
        $r->setData($data);
        $this->assertEquals($r::RESULT_SUCCESS, $r->getResult());
        $this->assertTrue($r->isSuccessful());
        $this->assertFalse($r->isError());
        $this->assertFalse($r->isException());
        $this->assertEquals($data, $r->getData());
        $this->assertEquals($r::HTTP_OK, $r->getHttpResponseCode());
        /* simulate an HTTP response */
        $json_encoded_string = $r->getHttpTransportResponse();
        /* simulate receiving request */
        $response = LeApiResponseModel::initFromHttpTransportResponse($json_encoded_string);
        $this->assertInstanceOf('Leroy\LeApi\LeApiResponseModel', $response);
        $this->assertEquals($data, $response->getData());
    }

    public function testExceptionObjectCreation()
    {
        $exception_msg = 'Throwing an Exception';
        $exception = new Exception($exception_msg);
        $r = new LeApiResponseModel();
        $r->setException($exception);
        $this->assertEquals($r::RESULT_EXCEPTION, $r->getResult());
        $this->assertTrue($r->isException());
        $this->assertFalse($r->isSuccessful());
        $this->assertFalse($r->isError());
        $this->assertEquals($exception, $r->getException());
        $this->assertEquals($r::HTTP_SERVER_ERROR, $r->getHttpResponseCode());
        /* simulate an HTTP response */
        $json_encoded_string = $r->getHttpTransportResponse();
        /* simulate receiving request */
        $response = LeApiResponseModel::initFromHttpTransportResponse($json_encoded_string);
        $this->assertInstanceOf('Leroy\LeApi\LeApiResponseModel', $response);
        $this->assertEquals($exception_msg, $response->getException());
    }

    public function testErrorObjectCreation()
    {
        $error_msg = 'Throwing an Exception';
        $r = new LeApiResponseModel();
        $r->setErrorMessage($error_msg);
        $this->assertEquals($r::RESULT_ERROR, $r->getResult());
        $this->assertTrue($r->isError());
        $this->assertFalse($r->isSuccessful());
        $this->assertFalse($r->isException());
        $this->assertEquals($error_msg, $r->getErrorMessage());
        $this->assertEquals($r::HTTP_BAD_REQUEST, $r->getHttpResponseCode());
        /* simulate an HTTP response */
        $json_encoded_string = $r->getHttpTransportResponse();
        /* simulate receiving request */
        $response = LeApiResponseModel::initFromHttpTransportResponse($json_encoded_string);
        $this->assertInstanceOf('Leroy\LeApi\LeApiResponseModel', $response);
        $this->assertEquals($error_msg, $response->getErrorMessage());
    }
}
