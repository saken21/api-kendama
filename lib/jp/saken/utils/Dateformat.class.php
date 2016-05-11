<?php

class jp_saken_utils_Dateformat {
	public function __construct(){}
	static function getDatetime($date) {
		return DateTools::format($date, "%Y-%m-%d %H:%M:%S");
	}
	static function getDate($date) {
		return DateTools::format($date, "%Y-%m-%d");
	}
	function __toString() { return 'jp.saken.utils.Dateformat'; }
}
