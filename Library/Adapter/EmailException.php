<?php
	/*
		Class : EmailException
		Déscription : Permet de gérer les exceptions
	 */
	 
	namespace fitzlucassen\FLFramework\Library\Adapter;

	class EmailException extends \Exception{
		private $_typeError = "";
		protected $_params = array();
		
		const NO_VIEW = "no view";
		const BAD_LAYOUT = "bad layout";
		/*
			Constructeur
		 */
		public function __construct($type, $params) {
			parent::__construct();
			$this->_typeError = $type;
			$this->_params = $params;
		}
		
		/***********
		 * GETTERS *
		 ***********/
		public static function getBAD_LAYOUT() {
			return self::BAD_LAYOUT;
		}
		public static function getNO_VIEW() {
			return self::NO_MODEL;
		}
		public function getType(){
			return $this->_typeError;
		}
		public function getParams(){
			return $this->_params;
		}
	}
