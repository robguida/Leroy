<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 1/11/2019
 * Time: 8:48 PM
 */

namespace Leroy\LeCache;

class LeApcCache implements LeCacheInterface
{
    /**
     * @param string $key
     * @param mixed $value
     * @param int $life
     * @return bool
     */
    public function add($key, $value, $life)
    {
        return apc_add($key, $value, $life);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return apc_fetch($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return apc_delete($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $life
     * @return bool
     */
    public function replace($key, $value, $life)
    {
        return apc_add($key, $value, $life);
    }
}