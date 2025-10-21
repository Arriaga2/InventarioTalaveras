<?php

class OperationTypeData {
    public static string $tablename = "operation_type";

    // ✅ Declaración de propiedades
    public int $id;
    public string $name;

    // ✅ Constructor moderno
    public function __construct() {
        $this->id = 0;
        $this->name = "";
    }

    public function add() {
        $sql = "INSERT INTO " . self::$tablename . " (name) ";
        $sql .= "VALUES (\"$this->name\")";
        Executor::doit($sql);
    }

    public static function delById($id) {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=$id";
        Executor::doit($sql);
    }

    public function del() {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id=$id";
        $query = Executor::doit($sql);
        $found = null;
        while ($r = $query[0]->fetch_array()) {
            $data = new OperationTypeData();
            $data->id = (int)$r['id'];
            $data->name = $r['name'];
            $found = $data;
            break;
        }
        return $found;
    }

    public static function getByName($name) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE name=\"$name\"";
        $query = Executor::doit($sql);
        $found = null;
        while ($r = $query[0]->fetch_array()) {
            $data = new OperationTypeData();
            $data->id = (int)$r['id'];
            $data->name = $r['name'];
            $found = $data;
            break;
        }
        return $found;
    }

    public static function getAll() {
        $sql = "SELECT * FROM " . self::$tablename . " ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        $array = array();
        while ($r = $query[0]->fetch_array()) {
            $data = new OperationTypeData();
            $data->id = (int)$r['id'];
            $data->name = $r['name'];
            $array[] = $data;
        }
        return $array;
    }
}

?>
