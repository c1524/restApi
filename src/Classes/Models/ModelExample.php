<?php
namespace RestApi\Models;

//use \RestApi\Models\Technic;
use \RestApi\Traits;


class ModelExample
{
    use Traits\Connection;
    use Traits\MemStorage;

    /**
     * @var int|null    Timestamp value when player last was online.
     */
    public $lastonline;

    /**
     * @var bool        Is in this chrono records exists full player`s data.
     */
    public $isfulldata;

    /**
     * @var array|null  Fully player`s data. Not null only if last full data was stored too far ago.
     */
    public $fulldata;

    public function __construct()
    {
        $this->initConnection();
        $this->initMemStorage();
    }
//
//    public function getItem($gameid, $id)
//    {
//        $id = (int)$id;
//        return $this->MemStorage->get(
//            $this->prefix.'.'.$gameid.'.'.$id,
//            function($memcache, $key, &$value) use ($gameid, $id) {
//                $lastUpdated = $this->MemStorage->get($this->prefix.'.'.$gameid.'.updated');
//                $value = empty($lastUpdated) ? $this->putToMemStorage($gameid, $key) : $this->getDbItem($gameid, $id);
//                return true;
//            }
//        );
//    }
//
//    public function updateMemStorage($gameid) {
//        $this->putToMemStorage($gameid);
//    }
//
//    private function getDbItem($gameid, $id)
//    {
//        $query = $this->Connection->query("SELECT * FROM `technics` WHERE `gameid`=? AND `id`=?", [$gameid, $id]);
//        /** @var  $Technic  Technic*/
//        if ($Technic = $query->fetch_object(Technic::class)) {
//            return $Technic;
//        } else {
//            return null;
//        }
//    }
//
//    private function putToMemStorage($gameid, $returnKey = null)
//    {
//        $result = null;
//        $query = $this->Connection->query("SELECT * FROM `technics` WHERE `gameid`=?", [$gameid]);
//        /** @var  $Technic  Technic*/
//        while ($Technic = $query->fetch_object(Technic::class)) {
//            $key = $this->prefix.'.'.$gameid.'.'.$Technic->id;
//            $this->MemStorage->set($key, $Technic);
//            if ($key === $returnKey) {
//                $result = $Technic;
//            }
//        }
//        $this->MemStorage->set($this->prefix.'.'.$gameid.'.updated', time());
//        return $result;
//    }
}