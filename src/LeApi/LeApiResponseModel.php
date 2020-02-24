<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/23/2018
 * Time: 8:57 AM
 */

namespace Leroy\LeApi;

use Exception;
use stdClass;

class LeApiResponseModel
{
    /** @var string */
    private $result;
    /** @var array */
    private $data;
    /** @var string */
    private $error_msg;
    /** @var Exception */
    private $exception;
    /** @var integer */
    private $http_response_code;

    const RESULT_SUCCESS = 'success';
    const RESULT_ERROR = 'error';
    const RESULT_EXCEPTION = 'exception';

    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_PAYMENT_REQ = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->result = null;
        $this->data = null;
        $this->error_msg = null;
        $this->exception = null;
        $this->http_response_code = null;
    }

    /**
     * @param string $response - json encoded string
     * @return bool|LeApiResponseModel
     */
    public static function initFromHttpTransportResponse($response)
    {
        $output = false;
        $json = json_decode($response);
        if ($json instanceof stdClass) {
            $response = unserialize($json->response);
            if ($response instanceof LeApiResponseModel) {
                $output = $response;
            }
        }
        return $output;
    }

    //<editor-fold desc="Setters">
    /**
     * @param array|mixed $input
     * @param int $code
     * @return bool
     */
    public function setData($input, $code = self::HTTP_OK)
    {
        $output = false;
        if (is_null($this->result)) {
            if (!is_array($input)) {
                $input = [$input];
            }
            $this->data = $input;
            $this->result = self::RESULT_SUCCESS;
            $this->http_response_code = $code;
            $output = true;
        }
        return $output;
    }

    /**
     * @param string $input
     * @param int $code
     * @return bool
     */
    public function setErrorMessage($input, $code = self::HTTP_BAD_REQUEST)
    {
        $output = false;
        if (is_null($this->result)) {
            $this->error_msg = $input;
            $this->result = self::RESULT_ERROR;
            if (!in_array($code, [self::HTTP_BAD_REQUEST, self::HTTP_PAYMENT_REQ, self::HTTP_FORBIDDEN])) {
                $code = self::HTTP_BAD_REQUEST;
            }
            $this->http_response_code = $code;
            $output = true;
        }
        return $output;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    public function setException(Exception $e)
    {
        $output = false;
        if (is_null($this->result)) {
            $this->exception = LeApiExceptionModel::init($e);
            $this->result = self::RESULT_EXCEPTION;
            $this->http_response_code = self::HTTP_SERVER_ERROR;
            $output = true;
        }
        return $output;
    }
    //</editor-fold>

    //<editor-fold desc="Getters">
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return !is_null($this->data);
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return !is_null($this->error_msg);
    }

    /**
     * @return bool
     */
    public function isException()
    {
        return !is_null($this->exception);
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return Exception|null
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param string $use_key_val_as_key
     * @return array
     *
     * @example $output = [
     *              'key1' => [one record set],
     *              'key2' => [ This will be the format when a key is found more than once in a record set
     *                  [one record set],
     *                  [one record set],
     *                  ...
     *               ]
     *           ];
     */
    public function getData($use_key_val_as_key = '')
    {
        if (!empty($use_key_val_as_key) &&
            !empty($this->data) &&
            array_key_exists($use_key_val_as_key, current($this->data))
        ) {
            $output = [];
            /** @var array $reformatted track which keys has had it's value reset to that the recordsets are in an subarray. */
            $reformatted = [];
            foreach ($this->data as $data) {
                $key = $data[$use_key_val_as_key];
                /* If the key exists in $output, then it is a one-to-many relationship to the record sets, and
                    we need to set up $output to link all the records for this $key value into a subarray. */
                if (array_key_exists($key, $output)) {
                    /* If the key already has a record set, then we need to find out if it has been reformatted.
                        If it has, then we can just set the record set to a new row. Otherwise, we need to
                        reformat the $key's value so that it is a one-to-many relationship as seen in @example key2. */
                    if (!in_array($key, $reformatted)) {
                        $reformatted[] = $key;
                        /* resetting $key to be an array with one record set */
                        $output[$key] = [$output[$key]];
                    }
                    /* Add the new record */
                    $output[$key][] = $data;
                } else {
                    $output[$key] = $data;
                }
            }
        } else {
            $output = $this->data;
        }
        return $output;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->error_msg;
    }

    /**
     * @return int|null
     */
    public function getHttpResponseCode()
    {
        return $this->http_response_code;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return [
            'result' => $this->result,
            'data' => $this->data,
            'msg' => $this->error_msg,
            'exception' => $this->exception,
            'response_code' => $this->http_response_code,
        ];
    }

    /**
     * @param bool $return_response_object
     * @return string
     */
    public function getHttpTransportResponse($return_response_object = true)
    {
        /* If the code is going to be sent HTTP, then the destination is unknown, and we do not want
            to reveal anything proprietary or give anyone a trace, which is like a map that can be used for hacking.
            So, we set the exception to the message of the exception and serialize that. Additionally, in order
            to serialize an Exception, we would need an custom Exception that extends Exception and implements
            the Serializable interface. */
        if ($this->isException()) {
            $this->exception = $this->exception->getMessage();
        }
        if ($return_response_object) {
            $output = json_encode(['response' => serialize($this)]);
        } else {
            $output = json_encode($this->getResponse());
        }
        return $output;
    }
    //</editor-fold>
}