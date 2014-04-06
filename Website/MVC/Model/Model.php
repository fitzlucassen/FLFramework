<?php

    namespace fitzlucassen\FLFramework\Website\MVC\Model;
    
    /*
	Class : Model
	Déscription : Model de donnée pour les pages du site
     */
    class Model {
		public $_headerInformations = null;
		public $_controller = "home";
		public $_action = "index";
		public $_params = array();
		
		public function __construct($manager, $params = array()) {
		    if(class_exists("HeaderRepository")){
				$Header = $manager->getStatic('Header');
				$this->_headerInformations = $Header->getAll();
		    }
		    // Les configuration de base générale pour le site en BDD
		    $this->_params = $params;
		}
    }
