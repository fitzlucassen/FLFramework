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
	    header('location: /Error/noConnexionAvailable');
	}
	
	public function noHeaderTableFound(){
	    header('location: /Error/noHeaderTableFound');
	}
	
	public function noRewritingFound(){
	    header('location: /Error/noRewritingFound');
	}
	
	public function noMultilingueFound(){
	    header('location: /Error/noMultilingueFound');
	}
	
	/**
	 * VIEW
	 */
	public function noModelProvided($params){
	    header('location: /Error/noModelProvided/' . $params['controller'] . '/' . $params['action']);
	}
	
	/**
	 * CONTROLLER
	 */
	public function controllerClassDoesntExist($params){
	    header('location: /Error/controllerClassDoesntExist/' . $params['file']);
	}
	
	public function controllerInstanceFailed($params){
	    header('location: /Error/controllerInstanceFailed/' . $params['controller']);
	}
	
	public function actionDoesntExist($params){
	    header('location: /Error/actionDoesntExist/' . $params['controller'] . '/' . $params['action']);
	}
    }