<?php
class ConfigurationData {
    public static $tablename = "configuration";

    public $id;
    public $short;
    public $name;
    public $kind;
    public $val;

    public function __construct(){
        $this->id = null;
        $this->short = "";
        $this->name = "";
        $this->kind = "";
        $this->val = "";
    }

    public function add(){
        $sql = "INSERT INTO ".self::$tablename." (short, name, kind, val) ";
        $sql .= "VALUES (\"$this->short\", \"$this->name\", \"$this->kind\", \"$this->val\")";
        Executor::doit($sql);
    }

    public static function delById($id){
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$id";
        Executor::doit($sql);
    }

    public function del(){
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$this->id";
        Executor::doit($sql);
    }

    public function update(){
        $sql = "UPDATE ".self::$tablename." SET val=\"$this->val\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        $found = null;
        $data = new ConfigurationData();
        while($r = $query[0]->fetch_array()){
            $data->id = $r['id'];
            $data->short = $r['short'];
            $data->name = $r['name'];
            $data->kind = $r['kind'];
            $data->val = $r['val'];
            $found = $data;
            break;
        }
        return $found;
    }

    public static function getAll(){
        $sql = "SELECT * FROM ".self::$tablename;
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new ConfigurationData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->short = $r['short'];
            $array[$cnt]->name = $r['name'];
            $array[$cnt]->kind = $r['kind'];
            $array[$cnt]->val = $r['val'];
            $cnt++;
        }
        return $array;
    }

    public static function getLike($q){
        $sql = "SELECT * FROM ".self::$tablename." WHERE name LIKE '%$q%'";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new ConfigurationData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->short = $r['short'];
            $array[$cnt]->name = $r['name'];
            $array[$cnt]->kind = $r['kind'];
            $array[$cnt]->val = $r['val'];
            $cnt++;
        }
        return $array;
    }
}
?>
