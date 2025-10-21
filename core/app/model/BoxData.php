<?php
class BoxData {
    public static $tablename = "box";

    public $id;
    public $created_at;

    public function __construct(){
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function add(){
        $sql = "INSERT INTO ".self::$tablename." (created_at) ";
        $sql .= "VALUES (\"$this->created_at\")";
        return Executor::doit($sql);
    }

    // resto de métodos (del, update, getById, etc.) sin el uso de 'name'

    public static function delById($id){
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$id";
        Executor::doit($sql);
    }

    public function del(){
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        $found = null;
        $data = new BoxData();
        while($r = $query[0]->fetch_array()){
            $data->id = $r['id'];
            $data->created_at = $r['created_at'];
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
            $array[$cnt] = new BoxData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->created_at = $r['created_at'];
            $cnt++;
        }
        return $array;
    }
}
?>
