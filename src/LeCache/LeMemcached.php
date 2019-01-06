<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 1/5/2019
 * Time: 6:22 PM
 */

namespace Leroy\LeCache;

use Memcached;

class LeMemcached implements LeCacheInterface
{
    /** @var Memcached */
    private $memcached;

    /**
     * LeMemcached constructor.
     * @param string $host
     * @param int $port
     */
    public function __construct($host, $port)
    {
        $this->memcached = new Memcached();
        $this->memcached->addServer($host, $port);
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $life
     * @return bool
     */
    public function add($key, $value, $life)
    {
        return $this->memcached->add($key, $value, $life);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
       return $this->memcached->get($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return $this->memcached->delete($key);
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $life
     * @return bool
     */
    public function replace($key, $value, $life)
    {
        return $this->memcached->replace($key, $value, $life);
    }
}
