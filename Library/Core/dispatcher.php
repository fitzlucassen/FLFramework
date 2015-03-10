<?php
     
    namespace fitzlucassen\FLFramework\Library\Core;

    use fitzlucassen\FLFramework\Library\Adapter;
    
    /*
      Class : Dispatcher
      Déscription : 
     */
    class Dispatcher {
    	private $_CONTROLLER_NAMESPACE = '\fitzlucassen\FLFramework\Website\MVC\Controller\\';
		private $_FLF_NAMESPACE = '\fitzlucassen\FLFramework\\';

		private $_errorManager = null;

    	private $_controllerName;
    	private $_actionName;
    	private $_controller;

    	public function __construct(){
    	}

    	public function getControllerFilePath($controllerName){
    		$this->_controllerName = $this->_CONTROLLER_NAMESPACE . ucwords($controllerName . 'Controller');

			$c = $this->_controllerName;
			$c2 = str_replace($this->_FLF_NAMESPACE, '', $c) . '.php';

			return array('fullPath' => $c, 'realPath' => $c2);
    	}

    	public function redirectTo404(){
			header('location: ' . __site_url__ . '/Home/error404');
		    die();
    	}

    	public function manageController(){
    		// On vérifie que le fichier de la classe de ce controller existe bien
			// Sinon on lance une exception en mode debug OU on redirige vers la page 404 en mode non debug
			$controllerFile =  $this->_controllerName . '.php';
			if(!file_exists(str_replace('\\', '/', str_replace($this->_FLF_NAMESPACE, '', $controllerFile)))){
				throw new Adapter\ControllerException(Adapter\ControllerException::NOT_FOUND, array('file' => $controllerFile));
			}

			// On vérifie que la classe existe bien
			// Sinon on lance une exception en mode debug OU on redirige vers la page 404 en mode non debug
			if(!class_exists($this->_controllerName)){
				throw new Adapter\ControllerException(Adapter\ControllerException::INSTANCE_FAIL, array('controller' => $this->_controllerName));
			}
    	}

    	public function manageAction($actionName, $repositoryManager){    		
    		$this->_actionName = $actionName;

    		// On instancie le controller
		    $this->_controller = new $this->_controllerName($this->_actionName, $repositoryManager);
    	}

    	public function isValidUrl($url){
            return      file_exists(str_replace('\\', '/', str_replace($this->_FLF_NAMESPACE, '', $this->_CONTROLLER_NAMESPACE . $url['controller'])) . 'Controller.php') && 
    				    class_exists($this->_CONTROLLER_NAMESPACE . $url['controller'] . 'Controller') &&
    				    method_exists($this->_CONTROLLER_NAMESPACE . $url['controller'] . 'Controller', $url['action']);
    	}

    	public function executeAction($url){
    		$actionName = $this->_actionName;
		    
		    // Si l'action n'existe pas, alors soit on lance une exeption en mode debug, soit on redirige vers la page 404 en mode non debug
		    if(!method_exists($this->_controllerName, $this->_actionName)){
			    throw new Adapter\ControllerException(Adapter\ControllerException::ACTION_NOT_FOUND, array("controller" => $url['controller'], "action" => $url['action']));
		    }
		    
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
    }