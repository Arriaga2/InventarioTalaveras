<?php
class PersonData {
    public static $tablename = "person";

    public $id;
    public $name;
    public $lastname;
    public $address1;
    public $email1;
    public $phone1;
    public $kind;
    public $created_at;

    public function __construct(){
        $this->id = null;
        $this->name = "";
        $this->lastname = "";
        $this->address1 = "";
        $this->email1 = "";
        $this->phone1 = "";
        $this->kind = 1; // default client
        $this->created_at = null; // se usa NOW() en SQL, no aquí
    }

    public function add_client(){
        $sql = "INSERT INTO ".self::$tablename." (name, lastname, address1, email1, phone1, kind, created_at) ";
        $sql .= "VALUES (\"$this->name\", \"$this->lastname\", \"$this->address1\", \"$this->email1\", \"$this->phone1\", 1, NOW())";
        Executor::doit($sql);
    }

    public function add_provider(){
        $sql = "INSERT INTO ".self::$tablename." (name, lastname, address1, email1, phone1, kind, created_at) ";
        $sql .= "VALUES (\"$this->name\", \"$this->lastname\", \"$this->address1\", \"$this->email1\", \"$this->phone1\", 2, NOW())";
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
        $sql = "UPDATE ".self::$tablename." SET name=\"$this->name\", email1=\"$this->email1\", address1=\"$this->address1\", lastname=\"$this->lastname\", phone1=\"$this->phone1\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public function update_client(){
        $this->update();
    }

    public function update_provider(){
        $this->update();
    }

    public function update_passwd(){
        $sql = "UPDATE ".self::$tablename." SET password=\"$this->password\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        $found = null;
        $data = new PersonData();
        while($r = $query[0]->fetch_array()){
            $data->id = $r['id'];
            $data->name = $r['name'];
            $data->lastname = $r['lastname'];
            $data->address1 = $r['address1'];
            $data->phone1 = $r['phone1'];
            $data->email1 = $r['email1'];
            $data->created_at = $r['created_at'];
            $data->kind = $r['kind'];
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
            $array[$cnt] = new PersonData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->name = $r['name'];
            $array[$cnt]->lastname = $r['lastname'];
            $array[$cnt]->email1 = $r['email1'];
            $array[$cnt]->phone1 = $r['phone1'];
            $array[$cnt]->address1 = $r['address1'];
            $array[$cnt]->created_at = $r['created_at'];
            $array[$cnt]->kind = $r['kind'];
            $cnt++;
        }
        return $array;
    }

    public static function getClients(){
        $sql = "SELECT * FROM ".self::$tablename." WHERE kind=1 ORDER BY name, lastname";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new PersonData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->name = $r['name'];
            $array[$cnt]->lastname = $r['lastname'];
            $array[$cnt]->email1 = $r['email1'];
            $array[$cnt]->phone1 = $r['phone1'];
            $array[$cnt]->address1 = $r['address1'];
            $array[$cnt]->created_at = $r['created_at'];
            $array[$cnt]->kind = $r['kind'];
            $cnt++;
        }
        return $array;
    }

    public static function getProviders(){
        $sql = "SELECT * FROM ".self::$tablename." WHERE kind=2 ORDER BY name, lastname";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new PersonData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->name = $r['name'];
            $array[$cnt]->lastname = $r['lastname'];
            $array[$cnt]->email1 = $r['email1'];
            $array[$cnt]->phone1 = $r['phone1'];
            $array[$cnt]->address1 = $r['address1'];
            $array[$cnt]->created_at = $r['created_at'];
            $array[$cnt]->kind = $r['kind'];
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
            $array[$cnt] = new PersonData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->name = $r['name'];
            $array[$cnt]->lastname = $r['lastname'];
            $array[$cnt]->email1 = $r['email1'];
            $array[$cnt]->phone1 = $r['phone1'];
            $array[$cnt]->address1 = $r['address1'];
            $array[$cnt]->created_at = $r['created_at'];
            $array[$cnt]->kind = $r['kind'];
            $cnt++;
        }
        return $array;
    }
}
?>
