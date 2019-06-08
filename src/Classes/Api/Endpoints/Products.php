<?php
namespace RestApi\Api\Endpoints;

use \RestApi\Api\ApiEndpoint;


class Products extends ApiEndpoint
{

    public function __construct()
    {
    }

    public function render()
    {
        return 'ok2';
    }
}