<?
	class VException extends Exception
	{

		public function __construct($message){
			print_r($message);

		}


		public static function run($text){
			return new self(
					"<BR>-----------------::::Default error: {$text} <br>---------------------------<BR>"
				);
				//echo '</pre>'
				//"<BR>-----------------::::Default error: {$text} <br>---------------------------<BR>"
		}

		public static function mysqli($text){
			return new self("---------------------MYSQL ERROR: {$text} -----------------------");
		}

		public function ormConnect($text){
			return new self(
				'::::Error connect to Database:'.$text
			);

		}
	}