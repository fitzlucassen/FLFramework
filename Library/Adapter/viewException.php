<?php
    /*
      Class : ViewException
      Déscription : Permet de gérer les exceptions
     */
     
    namespace fitzlucassen\FLFramework\Library\Adapter;

    class ViewException extends \Exception{
	protected $_params = array();
	 /*
	  Constructeur
	 */
	public function __construct($params) {
	    parent::__construct();
	    $this->_params = $params;
	}
	
	/***********
	 * GETTERS *
	 ***********/
	public function getParams(){
	    return $this->_params;
	}
    }