<?php
	class TMysqliTranlator{
				
		
		 public static function run ($query = array()){
		 	return self::select($query)
		 				.self::from($query)
		 				.self::where($query)
		 				.self::order($query)
						.self::limit($query)
                        .self::like($query);
			
		 }
		 
		 /**
		 * @desc преобрадование запроса SELECT
		 */
		public static function select ($field = array()){
			$selectField = null;	
			//  если значение не задано будем выбирать все поля
			foreach ($field['select'] as $value){
				if ($value['distinct']){
					$selectField.= ',DISTINCT ('.$value['field'].')';	
				}else{
					$selectField.=','.$value['field'];
				}
				

			}
			
			if (is_null($selectField)){
				return 'SELECT * ';
			}else{
				return 'SELECT '.substr($selectField, 1);
			}	
			
			
		}
		
		/*
		*   @params array   fields массив поелй key=>val
		*	
		*/
		public static function update (array $fields , array $params){
			$tableName =  $params['table'];
			$tkey      =  $params['key'];
			if (is_null($tableName)){
				throw VException::run ("tableName is null");
			}
			if (is_null($tkey)){
				throw VException::run('key is null');
			}

			if (is_array($fields)){
				$fieldsConvert=array();
				foreach ($fields as $key =>$val){
					$fieldsConvert[] = "`{$key}`='{$val}'";

				}
				return "UPDATE ".V_TABLE_PREF."{$tableName} 
						SET ".implode(',', $fieldsConvert)."
						WHERE `id`='{$tkey}'";
                
			}
			   
		}

		public static function delete(array $params){
			$tableName =  $params['table'];
			$tkey      =  $params['key'];
			if (is_null($tableName)){
				throw VException::run ("tableName is null");
			}
			if (is_null($tkey)){
				throw VException::run('key is null');
			}

			return "DELETE FROM  ".V_TABLE_PREF.$tableName
					." WHERE `id`='{$tkey}'";
            

		}
		
		/**
		 * @desc лиимитируем запросс выборки
		 * @param array $params
		 */
		public static function limit(array $params){
			$limitDown = $params['limit']['limit_down'];
			$limitUp   = $params['limit']['limit_up'];
			if (!is_null($limitUp)){
				return " LIMIT {$limitDown}, {$limitUp}";
			}
			
		}

		public static function order(array $query){
			$fieldOrder = $query['order'];
			if (!is_null($fieldOrder)){
				//$fieldOrder = 'id';
                return " ORDER BY (".$fieldOrder.") DESC";
            }

			
		}

	
		/**
		 * @desc инсерт данных
		 * @param array $fields
		 * @param array $params  $params['table'] -Имя таблицы для Insert  
		 * @param bool $keyInc инкремент ключа
		 * @return type
		 */
		public static function insert (array $fields, array $params){
			$tableName =  $params['table'];
			$keysData   = array_keys($fields);
			$valuesData = array_values($fields);
			$valuesData = "'".implode("','", $valuesData)."'";
			return "INSERT INTO `".V_TABLE_PREF."{$tableName}` 
					(".implode(',', $keysData).")
					VALUES(".$valuesData.")";
		}
		

		public static function from ($fields = array()){
			$fromField = null;	
			/**
			* @desc params $field 
			*		|	[0]  - table name
			*		|	[1]  - alias name
			*/
			foreach ($fields['from'] as $value){
				$tableName  = $value[0];
				$alias      = $value[1];
				//  если алиас не задан то
				// в качестве алиаса устанавливаем имя таблицы
				if (empty($alias)){
					$alias = $tableName;	
				}
				$fromField.=','.$tableName.' as '.$alias;
				
			}
			$splitFrom = V_TABLE_PREF.substr($fromField,1);
			return ' FROM '.$splitFrom;
			
		}
		
		
		/**
		* <code>
		* 	 ->where('field=?', key)
		* </code>
		*
		**/
		public static function where ($field = array()){
			$whereField = array();	
			if (is_array($field['where'])){
				foreach ($field['where'] as $extract){
					//парсим по одтельным кускам выражение типа ->where('id','=','1')
					$whereField[] = array('field' => $extract[0],
										  'value'   => "'$extract[1]'");

			    }
				if (count($whereField) > 0){
					$splitQuery = null;	
	
					foreach($whereField as $ext){
						// делаем замену ? на значение
						$splitQuery.= ' AND '.str_replace('?', $ext['value'], $ext['field']);
							
					}
					$splitQuery = substr($splitQuery, 5);
                  //  echo ' WHERE '.$splitQuery;
					return ' WHERE '.$splitQuery;
				}
				
			}
			
				
		}

        /**
         * <code>
         * 	 ->like('field=?', key)
         * </code>
         *
         **/
        public static function like ($field = array()){
            $whereField = array();
            if (is_array($field['like'])){
                foreach ($field['like'] as $extract){
                    //парсим по одтельным кускам выражение типа ->where('id','=','1')
                    $whereField[] = array('field' => $extract[0],
                        'value'   => "'%$extract[1]%'");
                }
//                if (count($whereField) > 0){
//                    $splitQuery = null;
//                    foreach($whereField as $ext){
//                        // делаем замену ? на значение
//                        $splitQuery.= ' AND '.str_replace('?', $ext['value'] , $ext['field']);
//
//                    }
                    //$splitQuery = substr($splitQuery, 5);
                $extract[0] = str_replace('=?', '' ,  $extract[0]);
                //echo " WHERE {$extract[0]} LIKE '%".$extract[1]."%'";
                return " WHERE {$extract[0]} LIKE '%".$extract[1]."%'";


            }


        }


		
		/**
		* <code>
		* 	 ->whereOr('field=?', key)
		* </code>
		*
		**/
		public static function whereOr ($field = array()){
			$whereField = array();	
			if (is_array($field['where'])){
				foreach ($field['where'] as $extract){
					//парсим по одтельным кускам выражение типа ->where('id','=','1')
					$whereField[] = array('field' => $extract[0],
										  'value'   => $extract[1]);
			}
				if (count($whereField) > 0){
					$splitQuery = null;	
	
					foreach($whereField as $ext){
						// делаем замену ? на значение
						$splitQuery.= ' OR '.str_replace('?', $ext['value'] , $ext['field']);
							
					}
					$splitQuery = substr($splitQuery, 5);
					return ' WHERE '.$splitQuery;
				}
				
			}
			
				
		}
			
	
		
	}
?>	