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
    	private $_databaseNeeded = true;
    	private $_urlRewritingNeeded = true;
    	private $_isInErrorPage = false;

    	private $_controllerName;
    	private $_actionName;
    	private $_controller;

    	public function __construct($urlrewrite = true, $db = true, $errorpage = false){
			$this->_urlRewritingNeeded = $urlrewrite;
			$this->_databaseNeeded = $db;
			$this->_isInErrorPage = $errorpage;

			$this->_errorManager = new Error();
    	}

    	public function manageController($controllerName, $debugMode){
			// On vérifie que le fichier de la classe de ce controller existe bien
			// Sinon on lance une exception en mode debug OU on redirige vers la page 404 en mode non debug
			$controllerFile =  $controllerName;
			if(!file_exists(str_replace($this->_FLF_NAMESPACE, '', $controllerFile))){
			    if($debugMode){
					Logger::write(Adapter\ControllerException::INSTANCE_FAIL . " : controllerInstanceFailed " . implode(' ', array('file' => $controllerFile)));
				    $this->_errorManager->controllerInstanceFailed(array('file' => $controllerFile));
				    die();
				}
			    else{
					header('location: /home/error404');
					die();
			    }
			}

			// On vérifie que la classe existe bien
			// Sinon on lance une exception en mode debug OU on redirige vers la page 404 en mode non debug
			if(!class_exists(str_replace('.php', '', $controllerFile))){
			    if($debugMode){
					Core\Logger::write(Adapter\ControllerException::NOT_FOUND . " : controllerClassDoesntExist " . implode(' ', array('controller' => $controllerFile)));
				    $this->_errorManager->controllerClassDoesntExist(array('controller' => $controllerFile));
				    die();
				}
			    else{
					header('location: /home/error404');
					die();
			    }
			}
    	}

    	public function manageAction($actionName, $url, $repositoryManager, $debugMode){
    		// On instancie le controller
    		$this->_actionName = $actionName;
		    $this->_controller = new $this->_controllerName($actionName, $repositoryManager);
		    
		    // On exécute l'action cible du controller et on affiche la vue avec le modèle renvoyé
		    try{
				$this->executeAction($url, $debugMode);
		    }
		    catch(Adapter\ControllerException $e){
				Logger::write(Adapter\ControllerException::ACTION_NOT_FOUND . " : actionDoesntExist " . implode(' ', $e->getParams()));
				$this->_errorManager->actionDoesntExist($e->getParams());
				die();
		    }
		    catch(Adapter\ViewException $ex){
				if($ex->getType() == Adapter\ViewException::NO_MODEL){
				    Logger::write(Adapter\ViewException::NO_MODEL . " : noModelProvided " . implode(' ', $ex->getParams()));
				    $this->_errorManager->noModelProvided($ex->getParams());
				    die();
				}
				else {
				    Logger::write(Adapter\ViewException::BAD_LAYOUT . " : layoutDoesntExist " . implode(' ', $ex->getParams()));
				    $this->_errorManager->layoutDoesntExist($ex->getParams());
				    die();
				}
		    }
    	}

    	public function executeAction($url, $debugMode){
		    $actionName = $this->_actionName;
		    
		    // Si l'action n'existe pas, alors soit on lance une exeption en mode debug, soit on redirige vers la page 404 en mode non debug
		    if(!method_exists($this->_controllerName, $this->_actionName)){
				if($debugMode)
				    throw new Adapter\ControllerException(Adapter\ControllerException::ACTION_NOT_FOUND, array("controller" => $url['controller'], "action" => $url['action']));
				else{
				    header('location: /home/error404');
				    die();
				}
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