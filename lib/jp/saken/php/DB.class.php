<?php

class jp_saken_php_DB {
	public function __construct(){}
	static $_host = "localhost";
	static $_user = "root";
	static $_password = "root";
	static function init($host, $user, $password) {
		jp_saken_php_DB::$_host = $host;
		jp_saken_php_DB::$_user = $user;
		jp_saken_php_DB::$_password = $password;
	}
	static function getConnection($dbname) {
		$dsn = "mysql:host=" . _hx_string_or_null(jp_saken_php_DB::$_host) . ";dbname=" . _hx_string_or_null($dbname) . ";charset=utf8";
		return php_db_PDO::open($dsn, jp_saken_php_DB::$_user, jp_saken_php_DB::$_password, null);
	}
	static function getJSON($list) {
		$results = (new _hx_array(array()));
		if(null == $list) throw new HException('null iterable');
		$__hx__it = $list->iterator();
		while($__hx__it->hasNext()) {
			$info = $__hx__it->next();
			$results->push(haxe_Json::phpJsonEncode($info, null, null));
		}
		return $results->toString();
	}
	static function getIsNGSQL($params) {
		if(null == $params) throw new HException('null iterable');
		$__hx__it = $params->iterator();
		while($__hx__it->hasNext()) {
			$value = $__hx__it->next();
			if(_hx_deref(new EReg("\"|'", ""))->match($value)) {
				return true;
			}
		}
		return false;
	}
	function __toString() { return 'jp.saken.php.DB'; }
}
