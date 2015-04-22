<?php

	namespace fitzlucassen\FLFramework\Website\MVC\Controller;
	
	use fitzlucassen\FLFramework\Website\MVC\Model;
	use fitzlucassen\FLFramework\Library\Helper;
	use fitzlucassen\FLFramework\Library\Adapter;
	use fitzlucassen\FLFramework\Data\Repository;
	use fitzlucassen\FLFramework\Library\Core;
	
	/*
		Class : HomeController
		Déscription : Permet de gérer les actions en relation avec le groupe de page Home
	*/
	class WebserviceController extends Controller {
		public function __construct($action, $manager) {
			parent::__construct("webservice", $action, $manager);
		}
		
		public function Index(){
			$Model = new Model\WebserviceModel($this->_repositoryManager);

			$this->setLayout('json');

			if(Core\Request::isPost()){
				// It's a form validation
				// Clean all vars
				$data = Core\Request::cleanRequest();

				// Process request...
				$Model->result = array(
					'user' => array(
						'id' => '',
						'email' => '',
						'creationdate' => ''
					)
				);
				$Model->result = json_encode($Model->result);
			}
			// Une action finira toujours par un $this->_view->view contenant : 
			// cette fonction prend en paramètre le modèle
			$this->_view->view($Model, 'json');
		}
	}