<?php
namespace RestApi;

use \RestApi\Traits;
use \RestApi\Utils;


class Api
{
    use Traits\AuthorizedUser;
    use Traits\Connection;


    public function __construct()
    {
        $this->initAuthorizedUser();
        $this->initConnection();
    }

    private function router()
    {
        $endpoint = Utils::getEndpoint();
        $className = '\RestApi\Api\Endpoints\\'.ucfirst($endpoint);
        if (!class_exists($className, true)) {
            throw new \Exception('Endpoint not found', 404);
        }
        if (!is_subclass_of($className, '\RestApi\Api\ApiEndpoint')) {
            throw new \Exception('Not allowed', 403);
        }

        /**
         * @var \RestApi\Api\ApiEndpoint $endpointObject
         */
        $endpointObject = new $className();
        return $endpointObject->render();
    }

    public function render()
    {
        header('Access-Control-Allow-Origin: *');

        try {
            echo json_encode(['result' => $this->router()]);
        } catch (\Exception $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' =>  $e->getMessage(), 'code' => $e->getCode()]);
        }
        exit;
    }

}