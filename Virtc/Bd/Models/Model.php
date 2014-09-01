<?
	/*
		@desc базовый класс для всех моделей
	*/

	class Model implements  ArrayAccess, Countable,  Iterator{
		protected  $_container = array();
     	protected $_position = 0;
     	protected $_items;
        protected  $_currentModel=null;

		var $_fields = array();
        var $_data = null;
		

		/*
		*  Конструктор модели при создании можно у
		*		казать модель с которой будем работать
		*/
		public function __construct($params = array(), $model){
			$this->_container = $params;
            $this->_currentModel = $model;
			return self;

		}


	/**
	* @desc обновление данных в таблице 
	* @param arrray $params параметры key => val
    * return  AdapterMysqli
	**/
	public function update(array $data ){
        $current = self::current();
		$query = TMysqliTranlator::update($data,
                                            array( 'table' => self::getCurentModel(),
                                                   'key'   => $current['id'])
                                                );
        return FactoryDb::getBdAdapter()->queryNoCache($query);
	}

    public function delete(){
        $current = self::current();
        $query = TMysqliTranlator::delete(array( 'table' => self::getCurentModel(),
                                                'key'   => $current['id'])
                                        ); 

        return FactoryDb::getBdAdapter()->queryNoCache($query);
   }


     /**
     *  @desc сохраняем данные модели 
	 * (подходить для вновь созданной модели)
     * @param $data - если укаан данные записываються из $data
     **/   
     public function save(){
        if ($this->_data!=null) {
            $query = TMysqliTranlator::insert($this->_data,
                array('table' =>$this->getCurentModel())
            );
            return FactoryDb::getBdAdapter()->insert($query);
        }else{
            return false;
        }


     }

     public function getResult(){
        return $this->_container;
     }

     public function getValues(){
        
     }

    /**
     * @desc Имя класса модели
     * @return string
     */
     public function modelName (){
             return get_class ($this);
     }

     public function getCurentModel(){
         return $this->_currentModel;
     }

      function offsetExists($offset){
         return isset($this->_container[$offset]);
     }
     
     public function offsetGet($offset){
         return $this->offsetExists($offset) ? $this->_container[$offset] : null;
     }
     
     public function offsetSet($offset, $value){
         if (is_null($offset)){
             $this->_container[] = $value;
         }else{
             $this->_container[$offset] = $value;
         }
     }
     
     public function offsetUnset($offset){
         unset($this->_container[$offset]);
     }
     
	 
     public function keySet($key){
		 $this->_container[$key]  = array('id' => $key);
         $this->_position = $key;
     }
	 
     public function rewind(){
         $this->_position = 0;
     }
     
     public function current(){
         return $this->_container[$this->_position];
     } 
     
     public function key(){
         return $this->_position;
     }
     
     public function next(){
         ++$this->_position;
     }
     
     public function valid(){
         return isset($this->_container[$this->_position]);
     }
     
     public function count(){
         return count($this->_container);
     }


        /**
     * @desc Преобразование коллекции к массиву
     * @return array
     */
    public function __toArray ()
    {
        $result = array (
            'class' => get_class ($this),
            'items' => array (),
            'data'  => $this->_data
        );
        foreach ($this as $item)
        {
           // $result ['items'][] = $item->__toArray ();
            print_r($item);
        }
        return $result;
    }

    

	}
