<?php
namespace RestApi\Traits;

use \RestApi\Config;
use \RestApi\Injector;


trait MemStorage
{
    /**
     * @var \Memcached
     */
    protected $MemStorage = null;

    protected function initMemStorage()
    {
        Config::init();

        $instanceName = 'MemStorage';
        if (!Injector::isCreated($instanceName)) {
            Injector::bind($instanceName, function () {
                $instance = new \Memcached();
                $instance->addServer(
                    Config::$data['Memcached']['host'],
                    Config::$data['Memcached']['port']
                );
                return $instance;
            });
        }
        $this->MemStorage = Injector::getInstance($instanceName);
    }
}