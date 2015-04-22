<?php
    /*
    	Class : ControllerException
    	Déscription : Permet de gérer les exceptions
     */
     
    namespace fitzlucassen\FLFramework\Library\Adapter;

    class ControllerException extends \Exception{
		private $_typeError = "";
		protected $_params = array();
			
		const NOT_FOUND = "not found";
		const INSTANCE_FAIL = "instance fail";
		const ACTION_NOT_FOUND = "no action";
		
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
		public static function getNOT_FOUND() {
		    return self::NOT_FOUND;
		}
		public static function getINSTANCE_FAIL() {
		    return self::INSTANCE_FAIL;
		}
		public static function getACTION_NOT_FOUND() {
		    return self::ACTION_NOT_FOUND;
		}
		public function getType(){
		    return $this->_typeError;
		}
		public function getParams(){
		    return $this->_params;
		}
    }
