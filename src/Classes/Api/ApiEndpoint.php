<?php
namespace RestApi\Api;


class ApiEndpoint
{
    public function render()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if ($method === 'options') {
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Credentials: true");
            header('Access-Control-Allow-Methods: GET, PATCH, POST, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
//            header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
            exit;
        }
        if (!method_exists($this, $method)) {
            throw new \Exception('Request method not supported', 405);
        }
        return $this->$method();
    }
}