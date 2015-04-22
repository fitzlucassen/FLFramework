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

		public static function redirectTo($url, $httpCode = 200, $contentType = ""){
			if(empty($contentType))
				$contentType = 'html';

			header('Content-type: ' . ContentType::getContentType($contentType));
			http_response_code($httpCode);

			header('location:' . $url);
			die();
		}
		
		/**
		 * IsPost
		 * @return boolean
		 */
		public static function isPost(){
			return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST';
		}
		
		/**
		 * IsGet
		 * @return boolean
		 */
		public static function isGet(){
			return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET';
		}

		/**
		 * isPut
		 * @return boolean
		 */
		public static function isPut(){
			return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT';
		}

		/**
		 * isDelete
		 * @return boolean
		 */
		public static function isDelete(){
			return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE';
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
			$vars = (self::isPost() ? $_POST : (self::isGet() ? $_GET : $_REQUEST));

			if(self::isPut()){
				$putVarsInString = file_get_contents("php://input");
				$matches = [];
				preg_match('/name\=\"([^"]*)\"[\ \n\t\r\n]{4}(.*)[\ \n\t\r\n]{2}[-]{6}/', $putVarsInString, $matches);
				while(isset($matches[1]) && isset($matches[2])){
					$vars[$matches[1]] = $matches[2];
					$putVarsInString = str_replace($matches[0], '', $putVarsInString);
					$matches = [];
					preg_match('/name\=\"([^"]*)\"[\ \n\t\r\n]{4}(.*)[\ \n\t\r\n]{2}[-]{6}/', $putVarsInString, $matches);
				}
			}
			
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
