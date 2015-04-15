<?php
	namespace fitzlucassen\FLFramework\Library\Core;
	
	/*
		Class : Request
		Déscription : Permet de gérer la couche serveur
	 */
	class Request {

		public function __construct() {
			parent::__construct();
		}
		
		/**
		 * IsPost
		 * @return boolean
		 */
		public static function isPost(){
			return isset($_POST) && !empty($_POST);
		}
		
		/**
		 * IsGet
		 * @return boolean
		 */
		public static function isGet(){
			return isset($_GET) && !empty($_GET);
		}

		/**
		 * isFile
		 * @return boolean
		 */
		public static function isFile(){
			return isset($_FILES) && !empty($_FILES);
		}


		private static function isJson($string) {
			return 	is_object($string) || is_array($string) ? false : true;
		}

		/**
		 * CleanPost
		 * @return array
		 */
		public static function cleanRequest(){
			$params = array();
			$vars = self::isPost() ? $_POST : $_GET;
			
			if(!self::isJson($vars)){
				foreach($vars as $key => $value){
					$params[$key] = Request::recursiveClean($value);
				}
				return $params;
			}
			else
				return $vars;
		}

		private static function recursiveClean(&$value){
			if(!is_array($value)){
				$value = Request::cleanValue($value);
				return $value;
			}
			else {
				foreach ($value as $key => &$valueMin) {
					$value[$key] = Request::recursiveClean($valueMin);
				}
				return $value;
			}
		}

		private static function cleanValue($value){
			if(gettype($value) == 'string'){
				$value = htmlspecialchars($value);
			}
			else if(in_array(gettype($value), array('integer', 'double'))){
				$value = intval($value);
			}
			return $value;
		}
	}