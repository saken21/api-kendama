<?php

class Main {
	public function __construct(){}
	static function main() {
		$params = php_Web::getParams();
		if(jp_saken_php_DB::getIsNGSQL($params)) {
			return;
		}
		{
			$_g = $params->get("mode");
			switch($_g) {
			case "insert":{
				Main::insertData($params);
			}break;
			case "update":{
				Main::updateData($params);
			}break;
			case "delete":{
				db_Kendama::deleteData($params->get("id"));
			}break;
			default:{
				Main::selectData($params);
			}break;
			}
		}
	}
	static function insertData($params) {
		$params->remove("mode");
		db_Kendama::insertData($params);
	}
	static function updateData($params) {
		$id = Std::parseInt($params->get("id"));
		if($id === null) {
			haxe_Log::trace("IDが必要です。", _hx_anonymous(array("fileName" => "Main.hx", "lineNumber" => 64, "className" => "Main", "methodName" => "updateData")));
			return;
		}
		$params->remove("mode");
		$params->remove("id");
		db_Kendama::updateData($id, $params);
	}
	static function selectData($params) {
		db_Kendama::init($params->get("keyword"));
		php_Lib::hprint(Main::getReslut(Std::parseInt($params->get("id")), $params->get("from"), $params->get("to")));
	}
	static function getReslut($id, $from, $to) {
		if($id !== null) {
			return db_Kendama::getByID($id);
		}
		if($from !== null && $to !== null) {
			return db_Kendama::getByTerm($from, $to);
		}
		return db_Kendama::getByKeyword();
	}
	function __toString() { return 'Main'; }
}
