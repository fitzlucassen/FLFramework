<?php

    namespace fitzlucassen\FLFramework\Website\MVC\Model;

    use fitzlucassen\FLFramework\Library\Helper;
    
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
				$Header = $manager->get('Header');

				$Session = new Helper\Session();
				$this->_headerInformations = $Header->getBy('lang', $Session->Read('lang'));

				if(is_array($this->_headerInformations))
					$this->_headerInformations = $this->_headerInformations[0];
		    }
		    // Les configuration de base générale pour le site en BDD
		    $this->_params = $params;
		}
    }
