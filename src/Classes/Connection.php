<?php
namespace RestApi;


class Connection
{
    /**
     * @var \mysqli
     */
    private $instance = null;


    public function __construct($instance)
    {
        $this->instance = $instance;
    }


    /**
     * @return \mysqli
     */
    protected function getConnection()
    {
        return $this->instance;
    }


    public function query($sql, $arguments=[])
    {
//  example:
//          $childQuery = $this->queryConnection($sql, [$type, $typepid]);
//			while ($childRow = $childQuery->fetch_assoc()) {
//				$childs[] = $childRow;
        $instance = $this->instance;
        $index = 0;
        $sql = preg_replace_callback(
            '/\?/',
            function($matches) use ($arguments, &$index, &$instance) {
                return "'".$instance->real_escape_string($arguments[$index++])."'";
            },
            $sql
        );
        return $instance->query($sql);
    }


    public function exec($sql, $arguments=[], $returnLastInsert = true)
    {
//        example: $this->historydata['id'] = (int)$this->execConnection($sql,$set3);
        $instance = $this->instance;
        if (!$query = $instance->prepare($sql)) {
            return false;
        }
        if (!empty($arguments)) {
            $autotypes = str_repeat('s', count($arguments));
            array_unshift($arguments, $autotypes);
            call_user_func_array([$query, 'bind_param'], $this->refValues($arguments));
        }
        $query->execute();
        return $returnLastInsert ? $instance->insert_id : true;
    }


    private function refValues($arr)
    {
        $refs = [];
        foreach ($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }
}