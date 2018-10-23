<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 10/23/2018
 * Time: 8:57 AM
 */

namespace Leroy\LeApi;

class LeApiResponseModel
{
    /** @var string */
    private $result;
    /** @var array */
    private $data;
    /** @var string */
    private $msg;

    const RESULT_SUCCESS = 'success';
    const RESULT_ERROR = 'error';

    public function __construct()
    {
        $this->result = self::RESULT_ERROR;
        $this->data = [];
        $this->msg = '';
    }

    public function setSuccessfulResponse()
    {
        $this->result = self::RESULT_SUCCESS;
    }

    public function setErrorResult()
    {
        $this->result = self::RESULT_ERROR;
    }

    public function setData($input)
    {
        if (!is_array($input)) {
            $input = [$input];
        }
        $this->data = $input;
    }

    public function setMessage($input)
    {
        $this->msg = $input;
    }

    public function getResponse()
    {
        return [
            'result' => $this->result,
            'data' => $this->data,
            'msg' => $this->msg,
        ];
    }
}