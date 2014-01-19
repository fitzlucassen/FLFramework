<?php

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
	    header('location: ' . __site_url__ . '/Error/noModelProvided/' . $params['controller'] . '/' . $params['action']);
	    die();
	}
	
	/**
	 * CONTROLLER
	 */
	public function controllerClassDoesntExist($params){
	    header('location: ' . __site_url__ . '/Error/controllerClassDoesntExist/' . $params['file']);
	    die();
	}
	
	public function controllerInstanceFailed($params){
	    header('location: ' . __site_url__ . '/Error/controllerInstanceFailed/' . $params['controller']);
	    die();
	}
	
	public function actionDoesntExist($params){
	    header('location: ' . __site_url__ . '/Error/actionDoesntExist/' . $params['controller'] . '/' . $params['action']);
	    die();
	}
    }