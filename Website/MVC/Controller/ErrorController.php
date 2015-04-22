<?php

	namespace fitzlucassen\FLFramework\Website\MVC\Controller;
	
	use fitzlucassen\FLFramework\Website\MVC\Model;
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
			$Model = new Model\ErrorModel($this->_repositoryManager);
			
			$this->_view->view($Model);
		}
		
		public function noHeaderTableFound(){
			$Model = new Model\ErrorModel($this->_repositoryManager);
			
			$this->_view->view($Model);
		}
		
		public function noRewritingFound(){
			$Model = new Model\ErrorModel($this->_repositoryManager);
			
			$this->_view->view($Model);
		}
		
		public function noMultilingueFound(){
			$Model = new Model\ErrorModel($this->_repositoryManager);
			
			$this->_view->view($Model);
		}

		public function queryFailed($params){
			$Model = new Model\ErrorModel($this->_repositoryManager, $params);
			
			$Model->_message = $params[0];

			$this->_view->view($Model);
		}
		
		/********
		 * VIEW *
		 ********/
		public function noModelProvided($params){
			$Model = new Model\ErrorModel($this->_repositoryManager, $params);
			
			$Model->_controllerTarget = $params[0];
			$Model->_modelTarget = $params[1];

			$this->_view->view($Model);
		}
		
		public function layoutDoesntExist($params){
			$Model = new Model\ErrorModel($this->_repositoryManager, $params);
			
			$Model->_layoutTarget = $params[0];

			$this->_view->view($Model);
		}
		
		/**************
		 * CONTROLLER *
		 **************/
		public function controllerClassDoesntExist($params){
			$Model = new Model\ErrorModel($this->_repositoryManager, $params);
			
			$Model->_controllerTarget = $params[0];
			
			$this->_view->view($Model);
		}
		
		public function controllerInstanceFailed($params){
			$Model = new Model\ErrorModel($this->_repositoryManager, $params);
			
			$Model->_controllerTarget = $params[0];
			
			$this->_view->view($Model);
		}
		
		public function actionDoesntExist($params){
			$Model = new Model\ErrorModel($this->_repositoryManager, $params);
			
			$Model->_controllerTarget = $params[0];
			$Model->_modelTarget = $params[1];

			$this->_view->view($Model);
		}

		/*********
		 * EMAIL *
		 *********/
		public function emailLayoutDoesntExist($params){
			$Model = new Model\ErrorModel($this->_repositoryManager, $params);
			
			$Model->_layoutTarget = $params[0];

			$this->_view->view($Model);
		}

		public function emailViewDoesntExist($params){
			$Model = new Model\ErrorModel($this->_repositoryManager, $params);
			
			$Model->_viewTarget = $params[0];

			$this->_view->view($Model);
		}
	}