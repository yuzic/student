<?
	class Loader{
		/**
		*  @desc список загуженных файлов
		*
		**/
		private static $_loaded = array();

        private static $type_patch = array(
            'Adapter' => 'Virtc/Bd/Adapters/',
            'Model'  => 'Virtc/Bd/Models/',
            'Helper' => 'Helpers/'

        );

		public static function load(array $data){
          try{
              $patch = $data['patch'];
              $file  = $data['file'];
              $pathFile = $patch.$file;
              $classLoad = str_replace('_', '/', $patch);
              require_once $classLoad.$file.'.php';
          }catch (VException $e){
              throw VException::run($e);
          }


		}

        /**
         *
         * @param string $type
         *              | Adapter
         *              | Model
         * @param type $class
         */
        public static function loadByType($type, $class){
           try{
               require_once self::$type_patch[$type].$class.'.php';
           } catch (VException $e){
               throw VException::run($e);
            }

           }

		public static function loadModel($model){
			self::load(array(
							'patch' => V_MODELS_PATCH.'Tables_',
							'file'  => $model));
		}

		/**
		* @desc захка необходимиго хелпера
		*
		*/
		public static function loadHelper($helper){
			self::load(array(
				'patch'	=> V_VIRTC.'_Class_Helper_',
				'file'	=> $helper
				));


		}

		public static function multiLoader(array $data){

		}


	}
