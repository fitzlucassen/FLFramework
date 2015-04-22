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
			Request::redirectTo(__site_url__ . '/Error/noConnexionAvailable', 500);
		}
		public function noHeaderTableFound(){
			Request::redirectTo(__site_url__ . '/Error/noHeaderTableFound', 500);

		}
		public function noRewritingFound(){
			Request::redirectTo(__site_url__ . '/Error/noRewritingFound', 500);
		}
		public function noMultilingueFound(){
			Request::redirectTo(__site_url__ . '/Error/noMultilingueFound', 500);
		}
		
		/**
		 * VIEW
		 */
		public function noModelProvided($params){
			Request::redirectTo(__site_url__ . '/Error/noModelProvided/' . str_replace('\\', '-', $params['controller']) . '/' . $params['action'], 500);
		}
		public function layoutDoesntExist($params){
			Request::redirectTo(__site_url__ . '/Error/layoutDoesntExist/' . str_replace('\\', '-', $params['layout']), 500);
		}
		
		/**
		 * CONTROLLER
		 */
		public function controllerClassDoesntExist($params){
			Request::redirectTo(__site_url__ . '/Error/controllerClassDoesntExist/' . str_replace('\\', '-', $params['file']), 500);
		}		
		public function controllerInstanceFailed($params){
			Request::redirectTo(__site_url__ . '/Error/controllerInstanceFailed/' . str_replace('\\', '-', $params['controller']), 500);
		}
		public function actionDoesntExist($params){
			Request::redirectTo(__site_url__ . '/Error/actionDoesntExist/' . str_replace('\\', '-', $params['controller']) . '/' . $params['action'], 500);
		}

		/**
		 * EMAIL
		 */
		public function emailLayoutDoesntExist($params){
			Request::redirectTo(__site_url__ . '/Error/emailLayoutDoesntExist/' . str_replace('\\', '-', $params['layout']), 500);
		}
		public function emailViewDoesntExist($params){
			Request::redirectTo(__site_url__ . '/Error/emailViewDoesntExist/' . str_replace('\\', '-', $params['view']), 500);
		}
	}
