<?php

    namespace fitzlucassen\FLFramework\Website\MVC\Controller;
    
    use fitzlucassen\FLFramework\Website\MVC\Model as models;
     /*
	Class : ErrorController
	Déscription : Permet de gérer les actions en relation avec le groupe de page Error
     */
    class ErrorController extends Controller {
	public function __construct($action, $manager) {
	    parent::__construct("error", $action, $manager);
	}
	
	/*************
	 * CONNEXION *
	 *************/
	public function noConnexionAvailable(){
	    // Une action commencera toujours par l'initilisation de son modèle
	    // Cette initialisation doit obligatoirement contenir le repository manager
	    $Model = new models\ErrorModel($this->_repositoryManager);
	    
	    // Une action finira toujours par un $this->_view->ViewCompact
	    // cette fonction prend en paramètre le modèle
	    $this->_view->ViewCompact($Model);
	}
	
	public function noHeaderTableFound(){
	    $Model = new models\ErrorModel($this->_repositoryManager);
	    
	    $this->_view->ViewCompact($Model);
	}
	
	public function noRewritingFound(){
	    $Model = new models\ErrorModel($this->_repositoryManager);
	    
	    $this->_view->ViewCompact($Model);
	}
	
	public function noMultilingueFound(){
	    $Model = new models\ErrorModel($this->_repositoryManager);
	    
	    $this->_view->ViewCompact($Model);
	}
	
	/********
	 * VIEW *
	 ********/
	public function noModelProvided($params){
	    $Model = new models\ErrorModel($this->_repositoryManager, $params);
	    
	    $Model->_controllerTarget = $params[0];
	    $Model->_modelTarget = $params[1];

	    $this->_view->ViewCompact($Model);
	}
	
	public function layoutDoesntExist($params){
	    $Model = new models\ErrorModel($this->_repositoryManager, $params);
	    
	    $Model->_layoutTarget = $params[0];

	    $this->_view->ViewCompact($Model);
	}
	
	/**************
	 * CONTROLLER *
	 **************/
	public function controllerClassDoesntExist($params){
	    $Model = new models\ErrorModel($this->_repositoryManager, $params);
	    
	    $Model->_controllerTarget = $params[0];
	    
	    $this->_view->ViewCompact($Model);
	}
	
	public function controllerInstanceFailed($params){
	    $Model = new models\ErrorModel($this->_repositoryManager, $params);
	    
	    $Model->_controllerTarget = $params[0];
	    
	    $this->_view->ViewCompact($Model);
	}
	
	public function actionDoesntExist($params){
	    $Model = new models\ErrorModel($this->_repositoryManager, $params);
	    
	    $Model->_controllerTarget = $params[0];
	    $Model->_modelTarget = $params[1];

	    $this->_view->ViewCompact($Model);
	}
    }