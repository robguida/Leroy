<?php


namespace Leroy\LeMVCS;


use ReflectionClass;
use ReflectionException;

abstract class LeViewModelAbstract
{
    /**
     * @param array $input
     * @return LeViewModelAbstract
     */
    public static function load(array $input)
    {
        $class = get_called_class();
        return new $class($input);
    }

    /**
     * LeViewModelAbstract constructor.
     * @param array $input
     * @throws ReflectionException
     */
    public function __construct(array $input)
    {
        $properties = get_class_vars((new ReflectionClass($this))->getName());
        foreach ($input as $key => $val) {
            if (array_key_exists($key, $properties)) {
                $this->$key = $val;
            }
        }
    }
}
