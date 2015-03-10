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
					if(gettype($value) == "string"){
					    $params[$key] = htmlspecialchars($value);
					}
					else if(in_array(gettype($value), array('integer', 'double'))){
					    $params[$key] = intval($value);
					}
			    }
			    return $params;
			}
			else
				return $vars;
		}
    }