<?php
class ProductData {
	public static $tablename = "product";

	// Todas las propiedades que utiliza esta clase deben estar definidas aquí.
	public $id;
	public $barcode;
	public $image;
	public $name;
	public $description;
	public $price_in;
	public $price_out;
	public $unit;
	public $presentation;
	public $user_id;
	public $category_id;
	public $inventary_min;
	public $is_active;
	public $created_at;

	public function __construct() {
		$this->barcode = "";
		$this->image = "";
		$this->name = "";
		$this->description = "";
		$this->price_in = "0";
		$this->price_out = "0";
		$this->unit = "";
		$this->presentation = "0";
		$this->user_id = null;
		$this->category_id = null;
		$this->inventary_min = 0;
		$this->is_active = 1;
		$this->created_at = "NOW()";
	}

	public function getCategory() {
		return CategoryData::getById($this->category_id);
	}

	public function add() {
		$sql = "INSERT INTO " . self::$tablename . " (barcode, name, description, price_in, price_out, user_id, presentation, unit, category_id, inventary_min, created_at) ";
		$sql .= "VALUES (\"$this->barcode\", \"$this->name\", \"$this->description\", \"$this->price_in\", \"$this->price_out\", $this->user_id, \"$this->presentation\", \"$this->unit\", $this->category_id, $this->inventary_min, NOW())";
		return Executor::doit($sql);
	}

	public function add_with_image() {
		$sql = "INSERT INTO " . self::$tablename . " (barcode, image, name, description, price_in, price_out, user_id, presentation, unit, category_id, inventary_min) ";
		$sql .= "VALUES (\"$this->barcode\", \"$this->image\", \"$this->name\", \"$this->description\", \"$this->price_in\", \"$this->price_out\", $this->user_id, \"$this->presentation\", \"$this->unit\", $this->category_id, $this->inventary_min)";
		return Executor::doit($sql);
	}

	public static function delById($id) {
		$sql = "DELETE FROM " . self::$tablename . " WHERE id=$id";
		return Executor::doit($sql);
	}

	public function del() {
		$sql = "DELETE FROM " . self::$tablename . " WHERE id=$this->id";
		return Executor::doit($sql);
	}

	public function update() {
		$sql = "UPDATE " . self::$tablename . " SET barcode=\"$this->barcode\", name=\"$this->name\", price_in=\"$this->price_in\", price_out=\"$this->price_out\", unit=\"$this->unit\", presentation=\"$this->presentation\", category_id=$this->category_id, inventary_min=\"$this->inventary_min\", description=\"$this->description\", is_active=\"$this->is_active\" WHERE id=$this->id";
		return Executor::doit($sql);
	}

	public function del_category() {
		$sql = "UPDATE " . self::$tablename . " SET category_id=NULL WHERE id=$this->id";
		return Executor::doit($sql);
	}

	public function update_image() {
		$sql = "UPDATE " . self::$tablename . " SET image=\"$this->image\" WHERE id=$this->id";
		return Executor::doit($sql);
	}

	public static function getById($id) {
		$sql = "SELECT * FROM " . self::$tablename . " WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ProductData());
	}

	public static function getAll() {
		$sql = "SELECT * FROM " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductData());
	}

	public static function getAllByPage($start_from, $limit) {
		// Validación para evitar errores de sintaxis si $start_from es NULL
		if (!is_numeric($start_from) || !is_numeric($limit)) {
			$start_from = 0;
			$limit = 10;
		}
		$sql = "SELECT * FROM " . self::$tablename . " LIMIT $start_from, $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductData());
	}

	public static function getLike($p) {
		$sql = "SELECT * FROM " . self::$tablename . " WHERE barcode LIKE '%$p%' OR name LIKE '%$p%' OR id LIKE '%$p%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductData());
	}

	public static function getAllByUserId($user_id) {
		$sql = "SELECT * FROM " . self::$tablename . " WHERE user_id=$user_id ORDER BY created_at DESC";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductData());
	}

	public static function getAllByCategoryId($category_id) {
		$sql = "SELECT * FROM " . self::$tablename . " WHERE category_id=$category_id ORDER BY created_at DESC";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductData());
	}
}
?>
