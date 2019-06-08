<?php
namespace RestApi;

use \RestApi\Injector;


class Config
{
    /**
     * @var array
     */
    static public $data = [];

    static public function init()
    {
        if (empty(self::$data)) {
            self::$data = include APP_ROOT . '/config.php';
        }
    }
}