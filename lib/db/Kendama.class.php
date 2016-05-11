<?php

class db_Kendama {
	public function __construct(){}
	static $_keyword;
	static $DB_NAME = "kendama";
	static $TABLE_NAME = "discs";
	static $COLUMNS = "*";
	static function init($keyword) {
		db_Kendama::$_keyword = $keyword;
	}
	static function getByKeyword() {
		return db_Kendama::get(null);
	}
	static function getByID($id) {
		return db_Kendama::get("id = " . _hx_string_rec($id, ""));
	}
	static function getByTerm($from, $to) {
		return db_Kendama::get("record_date between \"" . _hx_string_or_null($from) . "\" and \"" . _hx_string_or_null($to) . "\"");
	}
	static function insertData($map) {
		$connection = jp_saken_php_DB::getConnection("kendama");
		$columns = (new _hx_array(array()));
		$values = (new _hx_array(array()));
		$map = db_Kendama::getAddedUpdatetime($map);
		if(null == $map) throw new HException('null iterable');
		$__hx__it = $map->keys();
		while($__hx__it->hasNext()) {
			$key = $__hx__it->next();
			$columns->push($key);
			$values->push("\"" . _hx_string_or_null($map->get($key)) . "\"");
		}
		$request = "insert into " . "discs" . " (" . _hx_string_or_null($columns->join(",")) . ") values (" . _hx_string_or_null($values->join(",")) . ")";
		$connection->request($request);
	}
	static function updateData($id, $map) {
		$connection = jp_saken_php_DB::getConnection("kendama");
		$setList = (new _hx_array(array()));
		$map = db_Kendama::getAddedUpdatetime($map);
		if(null == $map) throw new HException('null iterable');
		$__hx__it = $map->keys();
		while($__hx__it->hasNext()) {
			$key = $__hx__it->next();
			$setList->push(_hx_string_or_null($key) . " = \"" . _hx_string_or_null($map->get($key)) . "\"");
		}
		$request = "update " . "discs" . " set " . _hx_string_or_null($setList->join(",")) . " where id = " . _hx_string_rec($id, "");
		$connection->request($request);
	}
	static function deleteData($id) {
		if($id === null) {
			return;
		}
		$connection = jp_saken_php_DB::getConnection("kendama");
		$request = "delete from " . "discs" . " where id = " . _hx_string_or_null($id);
		$connection->request($request);
	}
	static function get($where = null) {
		$hasWhere = $where !== null;
		if($hasWhere) {
			$where = " where " . _hx_string_or_null($where);
		}
		$where .= _hx_string_or_null(db_Kendama::getWhereByKeyword($hasWhere, db_Kendama::$_keyword));
		$connection = jp_saken_php_DB::getConnection("kendama");
		$resultSet = $connection->request("select " . "*" . " from " . "discs" . _hx_string_or_null($where));
		return jp_saken_php_DB::getJSON($resultSet->results());
	}
	static function getWhereByKeyword($hasWhere, $keyword) {
		if($keyword === null) {
			return "";
		}
		$head = null;
		if($hasWhere) {
			$head = " and ";
		} else {
			$head = " where ";
		}
		return _hx_string_or_null($head) . "concat_ws(char(0),name,team,clients,works,keywords,note) like \"%" . _hx_string_or_null($keyword) . "%\"";
	}
	static function getAddedUpdatetime($map) {
		{
			$v = jp_saken_utils_Dateformat::getDatetime(Date::now());
			$map->set("updatetime", $v);
			$v;
		}
		return $map;
	}
	function __toString() { return 'db.Kendama'; }
}
