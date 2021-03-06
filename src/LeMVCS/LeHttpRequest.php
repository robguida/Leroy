<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 11/10/2018
 * Time: 10:38 AM
 */

namespace Leroy\LeMVCS;

class LeHttpRequest
{
    /** @var array */
    private $data;

    const METHOD_POST = 'post';
    const METHOD_GET = 'get';
    const METHOD_CLI = 'cli';

    /**
     * LeHttpRequest constructor.
     * @param array|null $post
     * @param array|null $get
     * @param array|null $argv
     */
    protected function __construct($post = null, $get = null, $argv = null)
    {
        if (!is_null($post)) {
            $this->data[self::METHOD_POST] = $post;
        } elseif (!is_null($get)) {
            $this->data[self::METHOD_GET] = $get;
        } elseif (!is_null($argv)) {
            $this->data[self::METHOD_CLI] = $argv;
        }
    }

    //<editor-fold desc="Initializing functions">
    /**
     * @param array $input
     * @return LeHttpRequest
     */
    public static function loadPost(array $input)
    {
        return new LeHttpRequest($input);
    }

    /**
     * @param array $input
     * @return LeHttpRequest
     */
    public static function loadGet(array $input)
    {
        return new LeHttpRequest(null, $input);
    }

    /**
     * @param array $input
     * @return LeHttpRequest
     */
    public static function loadArgv(array $input)
    {
        return new LeHttpRequest(null, null, $input);
    }
    //</editor-fold>

    /**
     * @return bool
     */
    public function isPost()
    {
        return self::METHOD_POST == $this->getMethod();
    }

    /**
     * @return bool
     */
    public function isGet()
    {
        return self::METHOD_GET == $this->getMethod();
    }

    /**
     * @return bool
     */
    public function isCli()
    {
        return self::METHOD_CLI == $this->getMethod();
    }

    /**
     * @return bool|string
     */
    public function getMethod()
    {
        $output = false;
        if ($keys = array_keys($this->data)) {
            $output = current($keys);
        }
        return $output;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasKey(string $key) : bool
    {
        $data = $this->data[$this->getMethod()];
        return array_key_exists($key, $data);
    }

    /**
     * @param null $key
     * @return array|bool|mixed|null
     */
    public function get($key = null)
    {
        $data = $this->data[$this->getMethod()];
        if (is_null($key) && !is_null($data)) {
            $output = $data;
        } elseif (array_key_exists($key, $data)) {
            $output = $data[$key];
        } else {
            $output = false;
        }
        return $output;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function add($key, $value)
    {
        $this->data[$this->getMethod()][$key] = $value;
        return (array_key_exists($key, $this->data[$this->getMethod()]) &&
            $value == $this->data[$this->getMethod()][$key]);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function remove($key)
    {
        /* If the key does not exist, we return false. If it does exist,
            and it is removed then we return true; */
        if ($output = array_key_exists($key, $this->data[$this->getMethod()])) {
            unset($this->data[$this->getMethod()][$key]);
            $output = (!array_key_exists($key, $this->data[$this->getMethod()]));
        }
        return $output;
    }

    /**
     * @param array $input
     */
    public function loadArray(array $input)
    {
        foreach ($input as $key => $val) {
            $this->add($key, $val);
        }
    }
}
