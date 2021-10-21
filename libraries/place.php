<?php
class place{
    private $d;
    private $config;
    private $lang;
    public function __construct($d){
        $this->d = $d;
    }
    function getPlaceId($field_w,$table,$id,$field){
        $row = $this->d->rawQueryOne("select $field from #_".$table." where $field_w='".$id."' limit 0,1");
        return $row;
    }
    function getPlace($table,$field,$order='id desc'){
        $result = $this->d->rawQuery("select $field from #_".$table." order by $order");
        return $result;
    }
    function getFieldWhere($table,$id,$field_show,$fieldwhere,$order='numb asc, id desc'){
        $result = $this->d->rawQuery("select $field_show from #_$table where find_in_set ('hienthi',status) and $fieldwhere=$id order by $order");
        return $result;
    }
}