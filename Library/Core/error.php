<?php

    namespace fitzlucassen\FLFramework\Library\Core;
    
    /*
      Class : Error
      Déscription : Permet de gérer les erreurs
     */
    class Error {
	/*
	  Constructeur
	 */
	public function __construct() {
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
	public function layoutDoesntExist($params){
	    header('location: ' . __site_url__ . '/Error/layoutDoesntExist/' . str_replace('\\', '-', $params['layout']));
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