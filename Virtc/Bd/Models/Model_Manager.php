<?
class Model_Manager {

	/**
	 * @desc выполняем конечные действие в деструкторе
	 * 
	 */
	public function __construct(){
		
		
	}


	/**
	* @desc получаем модель по запросу
	*
	*/
	public static function byQuery($model, Query $query){
		Loader::loadModel($model);
        return new $model($query->run());
	}


	/**
	* @desc получаем модель с выбранной запсиью 
	*       по первчичному ключу
	*
	*/
	public static function byKey($model, $key){
		return self::byQuery($model,
							Query::instance()
							->select('*')
							->where('id=?', $key)
							->from($model));
	}




}