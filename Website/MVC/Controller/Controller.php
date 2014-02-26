<?php

    namespace fitzlucassen\FLFramework\Website\MVC\Controller;
    
    use fitzlucassen\FLFramework\Library\Core as cores;
    
     /*
	Class : Controller
	Déscription : Permet de gérer la classe mère de tous les controllers
     */
    class Controller {
	protected $_controller = "";
	protected $_action = "";
	protected $_repositoryManager = null;
	protected $_view = null;
	
	public function __construct($controller, $action, $manager) {	
	    $this->_controller = $controller;
	    $this->_action = $action;
	    $this->_view = new cores\View("");
	    $this->_repositoryManager = $manager;
	}
    }