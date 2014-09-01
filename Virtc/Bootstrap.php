<?
	class BootStrap{
	
		/**
		 * @desc  Инклудим необходимые данные ы 
		 */
		private static function __authoload(){
			require V_VIRTC.'/Config.php';
			require V_VIRTC.'/VirtcException.php';
			require V_VIRTC.'/Loader.php';
            require V_VIRTC.'/FactoryDb.php';
            require V_VIRTC.'/FactoryCache.php';
            require V_VIRTC.'/View.php';
            require V_VIRTC.'/Controller.php';
            require V_VIRTC.'/FrontController.php';
            require V_VIRTC.'/Request.php';

		}



		private static function modelInit(){
			require_once V_VIRTC.'/Bd/Query.php';
			require_once V_VIRTC.'/Bd/Translators/TMysqli.php';
			require_once V_VIRTC.'/Bd/Models/Model_Manager.php';
			require_once V_VIRTC.'/Bd/Models/Model.php';
			require_once V_VIRTC.'/Bd/Models/Model_Collection_Manager.php';
			

		}

        public static function Run(){
			self::__authoload();
			self::modelInit();
		}
		
	}