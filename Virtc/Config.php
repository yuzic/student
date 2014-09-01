<?
	class Config{
		/**
		 * @desc function load config
		 * @params $name name file Config in Configs
		 * @return 
		 */
		public static function load($name){
			return require "Configs/".$name.".php";
		}
	}