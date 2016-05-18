/**
* ================================================================================
*
* KendaMa API ver 1.00.00
*
* Author : KENTA SAKATA
* Since  : 2016/05/11
* Update : 2016/05/18
*
* Licensed under the MIT License
* Copyright (c) Kenta Sakata
* http://saken.jp/
*
* ================================================================================
*
**/
package;

import php.Web;
import php.Lib;
import jp.saken.php.DB;
import db.Kendama;

class Main {
	
	/* =======================================================================
	Public - Main
	========================================================================== */
	public static function main():Void {
		
		var params:Map<String,String> = Web.getParams();
		if (DB.getIsNGSQL(params)) return;
		
		switch (params['mode']) {
			
			case 'insert' : insertData(params);
			case 'update' : updateData(params);
			case 'delete' : Kendama.deleteData(params['id']);
			default       : selectData(params);
			
		}
		
	}
	
	/* =======================================================================
	Insert Data
	========================================================================== */
	private static function insertData(params:Map<String,String>):Void {
		
		params.remove('mode');
		Kendama.insertData(params);
		
	}
	
	/* =======================================================================
	Update Data
	========================================================================== */
	private static function updateData(params:Map<String,String>):Void {
		
		var id:Int = Std.parseInt(params['id']);
		
		if (id == null) {

			trace('IDが必要です。');
			return;

		}

		params.remove('mode');
		params.remove('id');

		Kendama.updateData(id,params);
		
	}
	
	/* =======================================================================
	Select Data
	========================================================================== */
	private static function selectData(params:Map<String,String>):Void {
		
		Kendama.init(params['keyword']);
		Lib.print(getReslut(Std.parseInt(params['id']),params['from'],params['to']));
		
	}
	
	/* =======================================================================
	Get Result
	========================================================================== */
	private static function getReslut(id:Int,from:String,to:String):String {
		
		if (id != null) return Kendama.getByID(id);
		if (from != null && to != null) return Kendama.getByTerm(from,to);
		
		return Kendama.getByKeyword();
		
	}

}