<?php
namespace RestApi;

use \RestApi\Traits;


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
        $endpoint = $this->getEndpoint();
        $className = '\RestApi\Api\Endpoints\\'.ucfirst($endpoint);
        if (!class_exists($className, true)) {
            throw new \Exception('Endpoint not found', 404);
        }
        if (!is_subclass_of($className, '\RestApi\Api\ApiEndpoint')) {
            throw new \Exception('Not allowed', 403);
        }
        return (new $className())->render();
    }

//    /**
//     * Get players from client`s list.
//     *
//     * @return mixed
//     * @throws \Exception
//     */
//    private function getUsersList()
//    {
//        if (!$this->AuthorizedUser->isAuthorized()) {
//            throw new \Exception('Not authorized', 401);
//        }
//        $query = $this->Connection->query(
//            "SELECT `p`.`id`,`p`.`nick`,`p`.`lastonline` FROM `players` as `p`, `player_list` as `l` ".
//            "WHERE `l`.`ownerid`=? AND `l`.`playerid`=`p`.`id` ORDER BY `l`.`sortid` ASC",
//            [$this->AuthorizedUser->id]
//        );
//        $players = [];
//        while ($player = $query->fetch_assoc()) {
//            //$datetime = new DateTime('2010-12-30 23:21:46');
//            //echo $datetime->format(DateTime::ATOM) /// Updated ISO8601
//            $players[] = $player;
//        }
//        return $players;
//    }
//
//    /**
//     * Add player into list of client.
//     *
//     * @return bool
//     * @throws \Exception
//     */
//    private function addUser()
//    {
//        $playerid = (int)$_POST['playerid'];
//        if (empty($playerid)) {
//            throw new \Exception('Player id not found', 400);
//        }
//
//        //1. Add user to known player table for scanning.
//        $query = $this->Connection->query("SELECT `id` FROM `players` WHERE `id`=?", [$playerid]);
//        if (!$query->fetch_assoc()) {
//            $this->Connection->exec("INSERT INTO `players`(`id`) VALUES (?)", [$playerid]);
//            (new Cron())->renderSingle($playerid);
//        }
//
//        //2. Add user to list of authorized user
//        if ($this->AuthorizedUser->isAuthorized()) {
//            $query = $this->Connection->query(
//                "SELECT `id` FROM `player_list` WHERE `ownerid`=? AND `playerid`=?",
//                [$this->AuthorizedUser->id, $playerid]
//            );
//            if (!$query->fetch_assoc()) {
//                $this->Connection->exec(
//                    "INSERT INTO `player_list`(`ownerid`, `playerid`) VALUES (?,?)",
//                    [$this->AuthorizedUser->id, $playerid]
//                );
//            }
//        } else {
//            throw new \Exception('Not authorized', 401);
//        }
//        return true;
//    }
//
//    /**
//     * Search player by started chars of name.
//     *
//     * @param $params
//     * @return mixed
//     * @throws \Exception
//     */
//    private function findUser($params)
//    {
//        $search = $params[1];
//        if (strlen($search) < 3) {
//            throw new \Exception('Search request too short', 400);
//        }
//        $limit = !empty($_GET['limit']) ? (int)$_GET['limit'] : 100;
//        return $this->WotApi->getAccountList('wot', $search, $limit);
//    }


    private function getEndpoint()
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