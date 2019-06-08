<?php
namespace RestApi\Traits;

use \RestApi\Config;
use \RestApi\AuthorizedUser as AuthorizedUserObj;
use \RestApi\Injector;


trait AuthorizedUser
{
    /**
     * @var \RestApi\AuthorizedUser
     */
    protected $AuthorizedUser = null;

    protected function initAuthorizedUser()
    {
        Config::init();

        $instanceName = 'AuthorizedUser';
        if (!Injector::isCreated($instanceName)) {
            Injector::bind($instanceName, function () {
                return new AuthorizedUserObj();
            });
        }
        $this->AuthorizedUser = Injector::getInstance($instanceName);
    }
}