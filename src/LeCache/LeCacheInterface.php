<?php

namespace Leroy\LeCache;

/**
 * Created by PhpStorm.
 * User: robert
 * Date: 1/5/2019
 * Time: 4:25 PM
 */
interface LeCacheInterface
{
    /**
     * @param string $key
     * @param string $value
     * @param int $life
     * @return bool
     */
    public function add($key, $value, $life);

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key);

    /**
     * @param string $key
     * @param string $value
     * @param int $life
     * @return bool
     */
    public function replace($key, $value, $life);
}