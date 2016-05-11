package db;

import sys.db.Connection;
import sys.db.ResultSet;
import jp.saken.php.DB;
import jp.saken.utils.Dateformat;

class Kendama {
	
	private static var _keyword:String;
	
	private static inline var DB_NAME   :String = 'kendama';
	private static inline var TABLE_NAME:String = 'discs';
	private static inline var COLUMNS   :String = '*';
	
	/* =======================================================================
	Public - Init
	========================================================================== */
	public static function init(keyword:String):Void {
		
		_keyword = keyword;
		
	}
	
		/* =======================================================================
		Public - Get By Keyword
		========================================================================== */
		public static function getByKeyword():String {

			return get();

		}
	
		/* =======================================================================
		Public - Get By ID
		========================================================================== */
		public static function getByID(id:Int):String {

			return get('id = ' + id);

		}

		/* =======================================================================
		Public - Get By Term
		========================================================================== */
		public static function getByTerm(from:String,to:String):String {

			return get('record_date between "' + from + '" and "' + to + '"');

		}
		
		/* =======================================================================
		Public - Insert Data
		========================================================================== */
		public static function insertData(map:Map<String,String>):Void {
			
			var connection:Connection    = DB.getConnection(DB_NAME);
			var columns   :Array<String> = [];
			var values    :Array<String> = [];
			
			map = getAddedUpdatetime(map);
			
			for (key in map.keys()) {
				
				columns.push(key);
				values.push('"' + map[key] + '"');
				
			}
			
			var request:String = 'insert into ' + TABLE_NAME + ' (' + columns.join(',') + ') values (' + values.join(',') + ')';
			connection.request(request);

		}
		
		/* =======================================================================
		Public - Update Data
		========================================================================== */
		public static function updateData(id:Int,map:Map<String,String>):Void {
			
			var connection:Connection    = DB.getConnection(DB_NAME);
			var setList   :Array<String> = [];
			
			map = getAddedUpdatetime(map);
			
			for (key in map.keys()) {
				setList.push(key + ' = "' + map[key] + '"');
			}
			
			var request:String = 'update ' + TABLE_NAME + ' set ' + setList.join(',') + ' where id = ' + id;
			connection.request(request);

		}
		
		/* =======================================================================
		Public - Delete Data
		========================================================================== */
		public static function deleteData(id:String):Void {
			
			if (id == null) return;
			
			var connection:Connection = DB.getConnection(DB_NAME);
			var request:String = 'delete from ' + TABLE_NAME + ' where id = ' + id;
			
			connection.request(request);

		}
	
	/* =======================================================================
	Get
	========================================================================== */
	private static function get(where:String = null):String {
		
		var hasWhere:Bool = (where != null);
		
		if (hasWhere) where = ' where ' + where;
		where += getWhereByKeyword(hasWhere,_keyword);
		
		var connection:Connection = DB.getConnection(DB_NAME);
		var resultSet :ResultSet  = connection.request('select ' + COLUMNS + ' from ' + TABLE_NAME + where);
		
		return DB.getJSON(resultSet.results());
		
	}
	
	/* =======================================================================
	Get Where By Keyword
	========================================================================== */
	private static function getWhereByKeyword(hasWhere:Bool,keyword:String):String {
		
		if (keyword == null) return '';
		
		var head:String = hasWhere ? ' and ' : ' where ';
		return head + 'concat_ws(char(0),name,team,clients,works,keywords,note) like "%' + keyword + '%"';
		
	}
	
	/* =======================================================================
	Add Updatetime
	========================================================================== */
	private static function getAddedUpdatetime(map:Map<String,String>):Map<String,String> {
		
		map['updatetime'] = Dateformat.getDatetime(Date.now());
		return map;
		
	}

}