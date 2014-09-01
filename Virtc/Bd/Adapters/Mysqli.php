<?
	class AdapterMysqli{
		public static $linkSelect = null;
        public static $connect = null;

   		/**
		 * @desc connect to bd
		 * @param array $params 
		 */
		public static function connect($params  = array()){
				$connect = mysqli_connect($params['host'], $params['login'],$params['pass']);
                self::$connect = $connect;
				if (!$connect){
					throw VException::ormConnect(
						'error connect to Database:'.$params['dbname']
					);
				}
				$select = mysqli_select_db($connect, $params['dbname']);
                mysqli_query($connect, 'SET NAMES utf8');
				if (!$select){
					throw  VException::ormConnect('database Mysqli not select');
				}
				if ($params['debug'] == true){
					echo mysql_error();
				}
				self::$linkSelect = $select;

		}

		/*
		*  @query без использования кеша
		 * @params string $sql -   
		*
		*/	
		public static function queryNoCache($sql){
			if (!is_null($sql)){
				$query = mysqli_query(self::$connect, $sql);
				if (!$query){
					    throw  VException::mysqli(mysql_error()."<<<".$sql.">>>");
				}
                return $query;
			}
		}

        public static function insert($sql){
            if (!is_null($sql)){
                $query = mysqli_query(self::$connect, $sql);
                if (!$query){
                    throw  VException::mysqli(mysql_error()."<<<".$sql.">>>");
                }
                return mysqli_insert_id(self::$connect);
            }
        }
		
		public static function query(array $query){
			//echo MysqliTranlator::run($query).'<br>';
			$queryString = TMysqliTranlator::run($query);
			$config = config::load('Redis');
			$keyMd5=  $config['key_preffix'].md5($queryString);
			// проверяем наличине в кеше
			//if (FactoryCache::getAdapter()->exists($keyMd5) == false){
				// устанавливаем значение кеша
	 			$result =  mysqli_query(self::$connect, TMysqliTranlator::run($query));
				$errno = mysql_error();
				if (empty($errno)){
                    $accosResult = array();
                    if ($result->num_rows > 0){
                        while ($fetch = $result->fetch_array()){
                            $accosResult[]=$fetch;
                        }
                    }
                   // FactoryCache::getAdapter()->set($keyMd5, $accosResult );
					return $accosResult;

				}else
					throw VException::mysqli($errno);
//
//			}else{
//				return FactoryCache::getAdapter()->get($keyMd5);
//			}
			
			
		}	

		
	}
