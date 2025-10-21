<?php
class OperationData {
    public static $tablename = "operation";

    public $id;
    public $name;
    public $product_id;
    public $q;
    public $cut_id;
    public $operation_type_id;
    public $sell_id;
    public $created_at;

    public function __construct(){
        $this->name = "";
        $this->product_id = "";
        $this->q = "";
        $this->cut_id = "";
        $this->operation_type_id = "";
        $this->sell_id = "";
        $this->created_at = "NOW()";
    }

    public function add(){
        $sell_id = isset($this->sell_id) && $this->sell_id != "" ? $this->sell_id : "NULL";
        $sql = "INSERT INTO ".self::$tablename." (product_id, q, operation_type_id, sell_id, created_at) ";
        $sql .= "VALUES (\"$this->product_id\", \"$this->q\", $this->operation_type_id, $sell_id, NOW())";
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

    public function update(){
        $sql = "UPDATE ".self::$tablename." SET product_id=\"$this->product_id\", q=\"$this->q\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new OperationData());
    }

    public static function getAll(){
        $sql = "SELECT * FROM ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getAllByDateOfficial($start, $end){
        if($start == $end){
            $sql = "SELECT * FROM ".self::$tablename." WHERE date(created_at) = \"$start\" ORDER BY created_at DESC";
        } else {
            $sql = "SELECT * FROM ".self::$tablename." WHERE date(created_at) >= \"$start\" AND date(created_at) <= \"$end\" ORDER BY created_at DESC";
        }
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getAllByDateOfficialBP($product, $start, $end){
        if($start == $end){
            $sql = "SELECT * FROM ".self::$tablename." WHERE date(created_at) = \"$start\" ORDER BY created_at DESC";
        } else {
            $sql = "SELECT * FROM ".self::$tablename." WHERE date(created_at) >= \"$start\" AND date(created_at) <= \"$end\" AND product_id=$product ORDER BY created_at DESC";
        }
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public function getProduct(){
        return ProductData::getById($this->product_id);
    }

    public function getOperationtype(){
        return OperationTypeData::getById($this->operation_type_id);
    }

    public static function getQYesF($product_id){
        $q = 0;
        $operations = self::getAllByProductId($product_id);
        $input_id = OperationTypeData::getByName("entrada")->id;
        $output_id = OperationTypeData::getByName("salida")->id;
        foreach($operations as $operation){
            if($operation->operation_type_id == $input_id){ $q += $operation->q; }
            else if($operation->operation_type_id == $output_id){ $q -= $operation->q; }
        }
        return $q;
    }

    public static function getAllByProductIdCutId($product_id, $cut_id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE product_id=$product_id AND cut_id=$cut_id ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getAllByProductId($product_id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE product_id=$product_id ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getAllByProductIdCutIdOficial($product_id, $cut_id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE product_id=$product_id AND cut_id=$cut_id ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getAllProductsBySellId($sell_id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE sell_id=$sell_id ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getAllByProductIdCutIdYesF($product_id, $cut_id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE product_id=$product_id AND cut_id=$cut_id ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getOutputQ($product_id, $cut_id){
        $q = 0;
        $operations = self::getOutputByProductIdCutId($product_id, $cut_id);
        $input_id = OperationTypeData::getByName("entrada")->id;
        $output_id = OperationTypeData::getByName("salida")->id;
        foreach($operations as $operation){
            if($operation->operation_type_id == $input_id){ $q += $operation->q; }
            else if($operation->operation_type_id == $output_id){ $q -= $operation->q; }
        }
        return $q;
    }

    public static function getOutputQYesF($product_id){
        $q = 0;
        $operations = self::getOutputByProductId($product_id);
        $input_id = OperationTypeData::getByName("entrada")->id;
        $output_id = OperationTypeData::getByName("salida")->id;
        foreach($operations as $operation){
            if($operation->operation_type_id == $input_id){ $q += $operation->q; }
            else if($operation->operation_type_id == $output_id){ $q -= $operation->q; }
        }
        return $q;
    }

    public static function getInputQYesF($product_id){
        $q = 0;
        $operations = self::getInputByProductId($product_id);
        $input_id = OperationTypeData::getByName("entrada")->id;
        foreach($operations as $operation){
            if($operation->operation_type_id == $input_id){ $q += $operation->q; }
        }
        return $q;
    }

    public static function getOutputByProductIdCutId($product_id, $cut_id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE product_id=$product_id AND cut_id=$cut_id AND operation_type_id=2 ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getOutputByProductId($product_id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE product_id=$product_id AND operation_type_id=2 ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getInputQ($product_id, $cut_id){
        $q = 0;
        $operations = self::getInputByProductId($product_id);
        $input_id = OperationTypeData::getByName("entrada")->id;
        $output_id = OperationTypeData::getByName("salida")->id;
        foreach($operations as $operation){
            if($operation->operation_type_id == $input_id){ $q += $operation->q; }
            else if($operation->operation_type_id == $output_id){ $q -= $operation->q; }
        }
        return $q;
    }

    public static function getInputByProductIdCutId($product_id, $cut_id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE product_id=$product_id AND cut_id=$cut_id AND operation_type_id=1 ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getInputByProductId($product_id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE product_id=$product_id AND operation_type_id=1 ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getInputByProductIdCutIdYesF($product_id, $cut_id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE product_id=$product_id AND cut_id=$cut_id AND operation_type_id=1 ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }
}
?>
