 <?

 class Model_Collection_Manager{


     public function __construct($array = null){
               
        
     }


    public static function byQuery($model, Query $query){
        //Loader::loadModel($model);
        return  new Model($query->run(),$model);
    }



 	
 }