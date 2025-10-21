<?php

// Model.php
// @brief Clase base para modelos (actualizado para PHP 8.2+)

class Model {

	public static function exists($modelname){
		$fullpath = self::getFullpath($modelname);
		return file_exists($fullpath);
	}

	public static function getFullpath($modelname){
		return Core::$root . "core/app/model/" . $modelname . ".php";
	}

	public static function many($query, $aclass){
		$cnt = 0;
		$array = array();
		while ($r = $query->fetch_array()) {
			$obj = new $aclass;
			$cnt2 = 1;
			foreach ($r as $key => $v) {
				if ($cnt2 > 0 && $cnt2 % 2 == 0) {
					if (property_exists($obj, $key)) {
						$obj->$key = $v;
					}
				}
				$cnt2++;
			}
			$array[$cnt] = $obj;
			$cnt++;
		}
		return $array;
	}

	public static function one($query, $aclass){
		$data = new $aclass;
		while ($r = $query->fetch_array()) {
			$cnt = 1;
			foreach ($r as $key => $v) {
				if ($cnt > 0 && $cnt % 2 == 0) {
					if (property_exists($data, $key)) {
						$data->$key = $v;
					}
				}
				$cnt++;
			}
			return $data;
		}
		return null;
	}
}

?>
