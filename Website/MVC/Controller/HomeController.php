<?php

    namespace fitzlucassen\FLFramework\Website\MVC\Controller;
    
    use fitzlucassen\FLFramework\Website\MVC\Model as models;
    use fitzlucassen\FLFramework\Library\Helper as helpers;
    
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
		    		    
		    // Une action finira toujours par un $this->_view->ViewCompact contenant : 
		    // cette fonction prend en paramètre le modèle
		    $this->_view->ViewCompact($Model);
		}
		
		public function Error404(){
		    $Model = new models\HomeModel($this->_repositoryManager);
		    
		    $this->_view->ViewCompact($Model);
		}
    }