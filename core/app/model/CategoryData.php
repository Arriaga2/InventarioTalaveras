<?php
class CategoryData {
    public static $tablename = "category";

    // Declarar propiedades explícitas
    public $id;
    public $name;
    public $created_at;

    // Constructor moderno
    public function __construct(){
        $this->id = null;
        $this->name = "";
        $this->created_at = null;
    }

    public function add(){
        // En SQL usar NOW() directamente, sin comillas
        $sql = "INSERT INTO ".self::$tablename." (name, created_at) ";
        $sql .= "VALUES (\"$this->name\", NOW())";
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
        $sql = "UPDATE ".self::$tablename." SET name=\"$this->name\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        $found = null;
        $data = new CategoryData();
        while($r = $query[0]->fetch_array()){
            $data->id = $r['id'];
            $data->name = $r['name'];
            $data->created_at = $r['created_at'] ?? null;
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
            $array[$cnt] = new CategoryData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->name = $r['name'];
            $array[$cnt]->created_at = $r['created_at'] ?? null;
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
            $array[$cnt] = new CategoryData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->name = $r['name'];
            $array[$cnt]->created_at = $r['created_at'] ?? null;
            $cnt++;
        }
        return $array;
    }
}
?>
