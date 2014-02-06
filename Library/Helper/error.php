<?php

    namespace fitzlucassen\FLFramework\Library\Helper;
    
    /*
      Class : Error
      Déscription : Permet de gérer les erreurs
     */
    class Error extends Helper {
	/*
	  Constructeur
	 */
	public function __construct($controller) {
	    parent::__construct($controller);
	}
	
	/**
	 * CONNEXION
	 */
	public function noConnexionAvailable(){
	    header('location: ' . __site_url__ . '/Error/noConnexionAvailable');
	    die();
	}
	
	public function noHeaderTableFound(){
	    header('location: ' . __site_url__ . '/Error/noHeaderTableFound');
	    die();
	}
	
	public function noRewritingFound(){
	    header('location: ' . __site_url__ . '/Error/noRewritingFound');
	    die();
	}
	
	public function noMultilingueFound(){
	    header('location: ' . __site_url__ . '/Error/noMultilingueFound');
	    die();
	}
	
	/**
	 * VIEW
	 */
	public function noModelProvided($params){
	    header('location: ' . __site_url__ . '/Error/noModelProvided/' . str_replace('\\', '-', $params['controller']) . '/' . $params['action']);
	    die();
	}
	
	/**
	 * CONTROLLER
	 */
	public function controllerClassDoesntExist($params){
	    header('location: ' . __site_url__ . '/Error/controllerClassDoesntExist/' . str_replace('\\', '-', $params['file']));
	    die();
	}
	
	public function controllerInstanceFailed($params){
	    header('location: ' . __site_url__ . '/Error/controllerInstanceFailed/' . str_replace('\\', '-', $params['controller']));
	    die();
	}
	
	public function actionDoesntExist($params){
	    header('location: ' . __site_url__ . '/Error/actionDoesntExist/' . str_replace('\\', '-', $params['controller']) . '/' . $params['action']);
	    die();
	}
    }