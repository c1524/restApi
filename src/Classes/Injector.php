<?php

namespace RestApi;


class Injector
{

    /** @var object[] */
    private static $instances = [];

    /** @var \Closure[] */
    private static $closures = [];

    /**
     * @param $name string
     * @param $closure \Closure
     */
    public static function bind($name, $closure)
    {
        self::$closures[$name] = $closure;
    }

    /**
     * @param $name
     *
     * @return object
     * @throws \Exception
     */
    //public static function &getInstance($name)
    public static function getInstance($name)
    {
        if (!isset(self::$instances[$name])) {
            self::refresh($name);
        }
        return self::$instances[$name];
    }

    public static function refresh($name)
    {
        if (!isset(self::$closures[$name])) {
            throw new \Exception("Instance closure $name is not defined");
        }
        $closure = self::$closures[$name];
        self::$instances[$name] = $closure();
    }

    public static function clear($name)
    {
        self::$instances[$name] = null;
    }

    public static function isCreated($name)
    {
        return isset(self::$instances[$name]);
    }
}