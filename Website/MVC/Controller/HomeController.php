<?php

    namespace fitzlucassen\FLFramework\Website\MVC\Controller;
    
    use fitzlucassen\FLFramework\Website\MVC\Model as models;
    
     /*
	Class : HomeController
	Déscription : Permet de gérer les actions en relation avec le groupe de page Home
     */
    class HomeController extends Controller {
	public function __construct($action, $manager) {
	    parent::__construct("home", $action, $manager);
	}
	
	public function Index(){
	    // Une action commencera toujours par l'initilisation de son modèle
	    // Cette initialisation doit obligatoirement contenir la connexion PDO et la langue.
	    $Model = new models\HomeModel($this->_repositoryManager);
	    
	    // Une action finira toujours par un $this->_view->ViewCompact contenant : 
	    // - La clef "Model" contenant le modèle de données à fournir à la vue
	    $this->_view->ViewCompact($this->_controller, $this->_action, array('Model' => $Model));
	}
	
	public function Error404(){
	    $Model = new Models\HomeModel($this->_repositoryManager);
	    $this->_view->ViewCompact($this->_controller, $this->_action, array('Model' => $Model));
	}
    }