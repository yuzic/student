<?
	class SchemaMysqli{
		public static $prefix='v_';

		public static function getPrefix(){
			return self::$prefix; 
		}
		
		public static function setPrefix($prefix){
			self::$prefix = $prefix;
		}
		
		
	}