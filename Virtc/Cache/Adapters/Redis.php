<?
	class AdapterRedis{
		public static  $linkSelect = null;

		/**
		 * 
		 * @param type $params
		 * @return Redis
		 */
		public  function __construct($params = array()){
			require_once V_VIRTC."/Cache/Redis/Redis.php";
			self::$linkSelect = new  Redis($params['host'], $params['port']);
			return self;
		}

        public static function instance(){
            return self::$linkSelect;
        }

        public static function get($key){
            return self::instance()->get($key);
        }

        public static function set($key){
            return self::instance()->get($key);
        }

        public static function exists($key){
            return self::instance()->exists($key);
        }

		/**
		 * @desc удаляем весь кеш
		 */
		public static function clear(){
			self::uses()->execute_command('flush all');
		}
		
		/**
		 * @desc удаляем кеш по точному ключу
		 * @param string $key
		 */
		public static function clearByKey($key){
			
		}
		
		/**
		 * @desc удаляем кеш по части ключа
		 * @param string $key
		 */
		public static function clearByCutKey($key){
			//echo "KEYS {$key}* ";
			return self::uses()->execute_command("keys katalog_**");
			
		}



	}
