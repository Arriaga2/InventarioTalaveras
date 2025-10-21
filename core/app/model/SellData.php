<?php
class SellData {
    public static $tablename = "sell";

    // Declaración explícita de propiedades para evitar advertencias
    public $id;
    public $total;
    public $discount;
    public $person_id;
    public $user_id;
    public $operation_type_id;
    public $box_id;
    public $created_at;

    public function __construct(){
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function getPerson() {
        return PersonData::getById($this->person_id);
    }

    public function getUser() {
        return UserData::getById($this->user_id);
    }

    public function add(){
        $sql = "INSERT INTO ".self::$tablename." (total,discount,user_id,created_at) ";
        $sql .= "VALUES ($this->total, $this->discount, $this->user_id, '$this->created_at')";
        return Executor::doit($sql);
    }

    public function add_re(){
        $sql = "INSERT INTO ".self::$tablename." (user_id,operation_type_id,created_at) ";
        $sql .= "VALUES ($this->user_id, 1, '$this->created_at')";
        return Executor::doit($sql);
    }

    public function add_with_client(){
        $sql = "INSERT INTO ".self::$tablename." (total,discount,person_id,user_id,created_at) ";
        $sql .= "VALUES ($this->total, $this->discount, $this->person_id, $this->user_id, '$this->created_at')";
        return Executor::doit($sql);
    }

    public function add_re_with_client(){
        $sql = "INSERT INTO ".self::$tablename." (person_id,operation_type_id,user_id,created_at) ";
        $sql .= "VALUES ($this->person_id, 1, $this->user_id, '$this->created_at')";
        return Executor::doit($sql);
    }

    public static function delById($id){
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$id";
        Executor::doit($sql);
    }

    public function del(){
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$this->id";
        Executor::doit($sql);
    }

    public function update_box(){
        $sql = "UPDATE ".self::$tablename." SET box_id=$this->box_id WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new SellData());
    }

    public static function getSells(){
        $sql = "SELECT * FROM ".self::$tablename." WHERE operation_type_id=2 ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }

    public static function getSellsUnBoxed(){
        $sql = "SELECT * FROM ".self::$tablename." WHERE operation_type_id=2 AND box_id IS NULL ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }

    public static function getByBoxId($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE operation_type_id=2 AND box_id=$id ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }

    public static function getRes(){
        $sql = "SELECT * FROM ".self::$tablename." WHERE operation_type_id=1 ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }

    public static function getAllByPage($start_from, $limit){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id <= $start_from LIMIT $limit";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }

    public static function getAllByDateOp($start, $end, $op){
        $sql = "SELECT * FROM ".self::$tablename." WHERE DATE(created_at) >= '$start' AND DATE(created_at) <= '$end' AND operation_type_id=$op ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }

    public static function getAllByDateBCOp($clientid, $start, $end, $op){
        // Usé person_id en vez de client_id para mantener coherencia con el resto del código
        $sql = "SELECT * FROM ".self::$tablename." WHERE DATE(created_at) >= '$start' AND DATE(created_at) <= '$end' AND person_id=$clientid AND operation_type_id=$op ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }
}
?>
