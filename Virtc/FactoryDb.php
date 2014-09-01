<?php
    class FactoryDb{

        /**
         * @return AdapterMysqli
         */
        public static function getBdAdapter(){
            $adapter = Config::load('Project');
			$adapterName = "Adapter{$adapter['adapterDb']}";
            Loader::loadByType('Adapter', $adapter['adapterDb']);
            $adapterName::connect(Config::load('Bd'));
			return  new $adapterName;
			
		}
		

					
		public static function getShemAdapter($shemName){
			require_once V_VIRTC."/Bd/Shems/{$shemName}.php";
			$classShemFactory = "Adapter{$shemName}";
			return new $classShemFactory;
		}
        
        	
        /**
         * @desc получаем адаптер базы данных
         */
        public static function getBdTranslator(){
            $adapter = Config::load('Project');
            BootStrap::shemFactory($adapter['translator']);
            
        }
    }
?>
