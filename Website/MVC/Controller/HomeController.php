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
	    // Cette initialisation doit obligatoirement contenir le repository manager
	    $Model = new models\HomeModel($this->_repositoryManager);
	    
	    $this->setLayout("bimbim");
	    // Une action finira toujours par un $this->_view->ViewCompact contenant : 
	    // cette fonction prend en paramètre le controller, l'action et le modèle
	    $this->_view->ViewCompact($this->_controller, $this->_action, $Model);
	}
	
	public function Error404(){
	    $Model = new Models\HomeModel($this->_repositoryManager);
	    $this->_view->ViewCompact($this->_controller, $this->_action, $Model);
	}
    }