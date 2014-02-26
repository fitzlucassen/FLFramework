<?php

    namespace fitzlucassen\FLFramework\Website\MVC\Model;
    
     /*
      Class : ErrorModel
      Déscription : Model de donnée pour les pages du controller error
     */
    class ErrorModel extends Model{
	public $_controllerTarget = "";
	public $_modelTarget = "";
	public $_layoutTarget = "";
	
	public function __construct($manager, $params = array()) {
	    parent::__construct($manager, $params);
	}
    }
