<?php

namespace RestApi;


class Utils
{
    static public function getEndpoint()
    {
        //[REQUEST_METHOD] => GET
        //[QUERY_STRING] => from=10
        //[REQUEST_URI] => /api/v1/products/tent?from=10
        if (empty($_SERVER['REQUEST_URI'])) {
            throw new \Exception('Bad request', 400);
        }
        list ($endpoint, $query) = explode('?', $_SERVER['REQUEST_URI'], 2);
        if (empty($endpoint)) {
            throw new \Exception('Bad request', 400);
        }

        $parts = preg_split('/\//', $endpoint, -1, PREG_SPLIT_NO_EMPTY);
        if ($parts[0] !== 'api') {
            throw new \Exception('Bad request', 400);
        }
        if ($parts[1] !== 'v1') {
            throw new \Exception('Version not supported', 404);
        }
        if (empty($parts[2])) {
            throw new \Exception('Endpoint not specified', 404);
        }
        return $parts[2];
    }

}
