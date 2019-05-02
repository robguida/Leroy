<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 11/27/2018
 * Time: 10:56 PM
 *
 */

namespace LeroyTest\LeApi;
require_once '/var/www/Leroy/src/bootstrap.php';
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

    public function testHttpTransportResponseNoObject()
    {
        /* test success */
        $r = new LeApiResponseModel();
        $r->setData(['data' => 'This is test data']);
        $this->assertHttpTransportResponseNoObject($r, 200);

        /* test error */
        $r = new LeApiResponseModel();
        $r->setErrorMessage('This is a test error');
        $this->assertHttpTransportResponseNoObject($r, 400);

        /* test exception */
        $exception = new Exception('This is a test exception');
        $r = new LeApiResponseModel();
        $r->setException($exception);
        $this->assertHttpTransportResponseNoObject($r, 500);
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

    /**
     * @param LeApiResponseModel $r
     */
    private function assertHttpTransportResponseNoObject(LeApiResponseModel $r)
    {
        $response = $r->getHttpTransportResponse(false);
        $this->assertTrue(is_string($response));
        $responseStdClass = json_decode($response);
        $this->assertInstanceOf('stdClass', $responseStdClass);
        if ($responseStdClass->data) {
            $this->assertInstanceOf('stdClass', $responseStdClass->data);
            /* makes sure no value is an object */
            foreach ($responseStdClass->data as $key => $val) {
                $this->assertTrue(in_array($key, ['result', 'data', 'msg', 'exception', 'response_code']));
                $this->assertFalse(is_object($val));
            }
        }
    }
}
