<?php

	namespace fitzlucassen\FLFramework\Library\Core;

	use fitzlucassen\FLFramework\Library\Adapter;
	
	/*
		Class : Dispatcher
		Déscription : 
	 */
	class Dispatcher {
		private $_CONTROLLER_NAMESPACE = '\\fitzlucassen\\FLFramework\\Website\MVC\\Controller\\';
		private $_FLF_NAMESPACE = '\\fitzlucassen\\FLFramework\\';

		private $_errorManager = null;

		private $_fullControllerName;
		private $_realControllerName;
		private $_actionName;
		private $_controllerName;
		private $_controller;

		public function __construct(){
		}

		public function setControllerFilePath($controllerName){
			$this->_controllerName = $controllerName;
			$this->_fullControllerName = $this->_CONTROLLER_NAMESPACE . ucwords($controllerName . 'Controller');
			$this->_realControllerName = str_replace($this->_FLF_NAMESPACE, '', $this->_fullControllerName) . '.php';
		}

		public function verifyController(){
			// On vérifie que le fichier de la classe de ce controller existe bien
			// Sinon on lance une exception
			if(!file_exists(str_replace('\\', '/', $this->_realControllerName))){
				throw new Adapter\ControllerException(Adapter\ControllerException::NOT_FOUND, array('file' => $this->_realControllerName));
			}

			// On vérifie que la classe existe bien
			// Sinon on lance une exception
			if(!class_exists($this->_fullControllerName)){
				throw new Adapter\ControllerException(Adapter\ControllerException::INSTANCE_FAIL, array('controller' => $this->_fullControllerName));
			}
		}

		public function verifyAction(){    		
			// Si l'action n'existe pas, alors soit on lance une exeption en mode debug
			if(!method_exists($this->_fullControllerName, $this->_actionName)){
				throw new Adapter\ControllerException(Adapter\ControllerException::ACTION_NOT_FOUND, array("controller" => $this->_fullControllerName, "action" => $this->_actionName));
			}
		}

		public function executeAction($url, $repositoryManager){			
			// On instancie le controller
			$this->_controller = new $this->_fullControllerName($this->_actionName, $repositoryManager);
			$actionName = $this->_actionName;
			
			// Si on a des paramètres dans l'url
			if(isset($url["params"])){
				// On exécute l'action
				$this->_controller->$actionName($url["params"]);
			}
			else{
				// On exécute l'action
				$this->_controller->$actionName();
			}
		}

		public function dispatch($contentType = '', $responseCode = 200){
			$View = new View();
			$View->setController($this->_controllerName);
			$View->setAction($this->_actionName);
			$View->view([], $contentType, $responseCode);
		}

		public function isValidUrl($url){
			return      file_exists(str_replace('\\', '/', str_replace($this->_FLF_NAMESPACE, '', $this->_CONTROLLER_NAMESPACE . ucfirst($url['controller']))) . 'Controller.php') && 
						class_exists($this->_CONTROLLER_NAMESPACE . ucfirst($url['controller']) . 'Controller') &&
						method_exists($this->_CONTROLLER_NAMESPACE . ucfirst($url['controller']) . 'Controller', $url['action']);
		}

		public function setAction($actionName){
			$this->_actionName = $actionName;
		}
	}
