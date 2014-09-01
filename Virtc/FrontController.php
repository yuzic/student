<?
	class FrontController{
        protected $_params,
                  $_controller,
                  $_action  ;
        static $_instance;

        public static function instance() {
            if(!(self::$_instance instanceof self))
                self::$_instance = new self();
            return self::$_instance;

        }


        private function __construct(){
            $request = $_SERVER['REQUEST_URI'];
            $splits = explode('/', trim($request,'/'));
            $this->_controller =!empty($splits[0]) ? ucfirst($splits[0]).'Controller':'IndexController';
            $this->_action = !empty($splits[1]) ? 'action'.$splits[1]:'actionIndex';
            if(!empty($splits[2])){
                $keys = $values = array();
                for($i=2, $cnt = count($splits); $i < $cnt; $i++){
                    if($i % 2 == 0){
                        $keys[] = $splits[$i];
                    }else{
                        $values[] = $splits[$i];}
                }
                $this->_params = array_combine($keys, $values);
            }
        }

        public function getAction(){
            return $this->_action;
        }

        public function getParams(){
            return $this->_params;
        }

        public function getController(){
            return $this->_controller;
        }


        /**
         * @desc запускаем всю систему в действие
         * array @params список параметров
         */
        public function route($params = array()){
            require_once 'Application/Controllers/'.$this->getController().'.php';
            $controller = $this->getController();
            $action = $this->getAction();
            $controller = new $controller();
            $controller->$action();

        }
	}
	