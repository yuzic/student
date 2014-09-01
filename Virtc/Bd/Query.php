<?
class Query{
		
	/**
	* @desc  параметры запросов
	*/
	private static $queryParts = array(
		'distinct'=> false,
		'select' => array(),
		'where'  => array(),
        'like'   =>array(),
		'from'   => array(),
		'order'  => null,
		'limit'	 => array()

	);
	
       /**
	 * @desc Создает и возвращает новый запрос.
	 * Аналогично "new Query()".
	 * @return Query Новый запрос.
	 */
	public static function instance(){
		return new self;
	}
			
	public static function run(){
		$result = FactoryDb::getBdAdapter()->query(self::$queryParts);
		self::resetParams();
		return $result;

	}

    /**
     * @desc Получение массива в виде ассоциативного массива, нумерованного массива, или обоих
     * @param string $query Запрос
     */
    public static function getArray($query)
    {
        if (!$result = self::asQuery($query)) {
            throw new DBException('Ошибка при выполнении запроса к БД: "'. htmlspecialchars($query) .'"');
        }

        $array = null;
        if ($result->num_rows > 0){
            while ($tmp = $result->fetch_array()){
                $array[] = $tmp;
            }
            $result->close();
        }

        return $array;
    }

    /**
     * @desc Получение массива в виде ассоциативного массива, нумерованного массива, или обоих
     * @param string $query Запрос
     */
    public static function getRow($query)
    {
        if (!$result = self::asQuery($query)) {
            throw new DBException('Ошибка при выполнении запроса к БД: "'. htmlspecialchars($query) .'"');
        }

        $array = null;
        if ($result->num_rows > 0){
            return $result->fetch_assoc();
        }
    }

    public static function asQuery($sql){
        return  FactoryDb::getBdAdapter()->queryNoCache($sql);
    }
	
	public static function resetParams(){
		self::$queryParts = array(); 
	}
	
		
	/**
	 * @return Query
	*/
	public static function select($query){
		self::$queryParts['select'][]= array('field' => $query,
                                                    'distinct'	 =>	false
                                           );
		return new self;
	}

	/**
	*  <code>
	*    $rw = Model_Manager::select('vdata.fio')
	*			->distinct()
	*			->select('vus.id, vus.email')
	*			->from('v_users','vus')
	*  </code>
	* @return Query  
	*/
	public static function distinct($flag = true){
        self::$queryParts['distinct'] = (bool) $flag;
		// пока костыль чуствую из за нехватки опыта :xDD ))
		$countSelect = count(self::$queryParts['select']);
		$addSelectDistinct = array_pop(self::$queryParts['select']);
		self::$queryParts['select'][$countSelect - 1] = array('field'    => $addSelectDistinct['field'],
                                                              'distinct' => self::$queryParts['distinct']	
                                                               );
        return new self();
			    
	}	
	
	  /**
	 * @desc делает from из таблицы.
	 * @return Query Новый запрос.
	 */
	public static function from($table, $alias = null){
		self::$queryParts['from'][]= array($table, $alias);
		return new self();
	}
                
	
		
	/**
	 * @return  Query Новый запрос.
	 */
	public static function where($field1, $value){
		self::$queryParts['where'][]= array($field1, $value);
		return new self();
	}

    /**
     * @return  Query Новый запрос.
     */
    public static function like($field1, $value){
        self::$queryParts['like'][]= array($field1, $value);
        return new self();
    }

	/**
         * 
         * @param type $field
         * @return Order
         */
	public static function order($field){
		self::$queryParts['order'] = $field;
		return new self();
	}
	
	/**
	 * @desc лимитируем запрос
	 * @param int $limit1
	 * @param int $limit2
	 * @return Query
	 */
	public static function limit($limit_down =0, $limit_up = 0){
		// оставлем только верхний предел 
		if (is_null($limit_up)){
			$limit_up = $limit_down;
			$limit_down = 0;
		}
		self::$queryParts['limit']= array(
			'limit_down' => $limit_down, 
			'limit_up'	 => $limit_up
		);
		return new self();	
	}
	
	/**
	 * @desc инсерт данных в таблицу
	 * @param array $fields
	 * @param array $params
	 * @return array
	 */
	public static function insert($fields, $params){
		$sql = MysqliTranlator::insert($fields, $params);
		return AdapterMysqli::queryNoCache($sql);
		
	}

	/**
	 * @desc обновление данных поля
	 * @param array $fields
	 * @param array $params
	 * @return array
	 */
	public static function update($fields, $params){
		$sql = MysqliTranlator::update($fields, $params);
		return AdapterMysqli::queryNoCache($sql);
	}
		

}
