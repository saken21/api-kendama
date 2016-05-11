<?php

class jp_saken_utils_Dateformat {
	public function __construct(){}
	static function getDatetime($date) {
		return DateTools::format($date, "%Y-%m-%d %H:%M:%S");
	}
	static function getDate($date) {
		return DateTools::format($date, "%Y-%m-%d");
	}
	static function getMonth($date) {
		return DateTools::format($date, "%Y-%m");
	}
	static function getAddedDate($date, $plus) {
		return Date::fromTime($date->getTime() + $plus * 24.0 * 60.0 * 60.0 * 1000.0);
	}
	function __toString() { return 'jp.saken.utils.Dateformat'; }
}
