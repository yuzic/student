<?php
	class User extends Model{
		
		/**
		 * @desc описываем поля модели
		 */
		private static $fields = array(
			'id' => null,
			'email' => null,
			'password'	=> null,

		);
		
		/**
		 * @desc описываем настройки кеширования
		 * 
		 * @var type array
		 */
		private static $cacheSettings = array(
			'time_reload'  => 300,   // время жизни кеша
			'chached'	   => true,
            'isHot'        =>false,  // подогрев кеша
			'prefix'	   =>'user',
			'limit_records' => true,    //  разбивать записи по лиммитам
			'count_limit_records' => 10 // по сколько разбивать
		);
		
		public static function getRow(){

		}
			
	}
