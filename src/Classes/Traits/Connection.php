<?php
namespace RestApi\Traits;

use \RestApi\Config;
use \RestApi\Connection as ConnectionObj;
use \RestApi\Injector;


trait Connection
{
    /**
     * @var \RestApi\Connection
     */
    protected $Connection = null;

    protected function initConnection()
    {
        Config::init();

        $instanceName = 'Connection';
        if (!Injector::isCreated($instanceName)) {
            Injector::bind($instanceName, function () {
                $instance = new \mysqli(
                    Config::$data['DB']['host'],
                    Config::$data['DB']['username'],
                    Config::$data['DB']['password'],
                    Config::$data['DB']['dbname']
                );
                if (mysqli_connect_errno()) {
                    throw new \Exception("Can`t connect: " . mysqli_connect_error());
                }
                $instance->set_charset("utf8");
                return new ConnectionObj($instance);
            });
        }
        $this->Connection = Injector::getInstance($instanceName);
    }
}