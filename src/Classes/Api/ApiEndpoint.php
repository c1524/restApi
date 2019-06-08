<?php
namespace RestApi\Api;


class ApiEndpoint
{
    public function render()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if (!method_exists($this, $method)) {
            throw new \Exception('Request method not supported', 405);
        }
        return $this->$method();
    }
}