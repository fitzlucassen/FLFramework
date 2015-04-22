<?php
	/*
		Class : ConnexionException
		Déscription : Permet de gérer les exceptions
	 */
	
	namespace fitzlucassen\FLFramework\Library\Adapter;

	class ConnexionException extends \Exception{
		private $_typeError = "";
		protected $_params = array();
			
		const NO_DB_FOUND = "no db";
		const NO_HEADER_TABLE_FOUND = "no header";
		const NO_URL_REWRITING_FOUND = "no rewriting";
		const NO_LANG_FOUND = "no lang";
		const QUERY_FAILED = "query failed";
		
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
		public static function getNO_DB_FOUND() {
			return self::NO_DB_FOUND;
		}
		public static function getNO_HEADER_TABLE_FOUND() {
			return self::NO_HEADER_TABLE_FOUND;
		}
		public static function getNO_URL_REWRITING_FOUND() {
			return self::NO_URL_REWRITING_FOUND;
		}
		public static function getNO_LANG_FOUND() {
			return self::NO_LANG_FOUND;
		}
		public static function getQUERY_FAILED() {
			return self::QUERY_FAILED;
		}
		public function getType(){
			return $this->_typeError;
		}
		public function getParams(){
			return $this->_params;
		}
	}
