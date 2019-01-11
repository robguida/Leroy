<?php

namespace Leroy\LeCache;

/**
 * Created by PhpStorm.
 * User: robert
 * Date: 1/5/2019
 * Time: 4:25 PM
 */
class LeCacheFactory implements LeCacheInterface
{
    private $cacheEngine;

    /**
     * LeCacheFactory constructor.
     * @param string $cache_engine
     * @param array $params
     */
    public function __construct($cache_engine = 'memcached', array $params = ['host' => '127.0.0.1', 'port' => 11211])
    {
        switch($cache_engine) {
            case 'memcached':
                $this->cacheEngine = new LeMemcached($params['host'], (int)$params['port']);
                break;
            case '':
                break;
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $life
     * @return bool
     */
    public function add($key, $value, $life = 0)
    {
        return $this->cacheEngine->add($key, $value, $life);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->cacheEngine->get($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return $this->cacheEngine->delete($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $life
     * @return bool
     */
    public function replace($key, $value, $life)
    {
        return $this->cacheEngine->replace($key, $value, $life);
    }
}
