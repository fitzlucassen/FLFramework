<?php
	 
	namespace fitzlucassen\FLFramework\Library\Core;
	use fitzlucassen\FLFramework\Library\Adapter;
	/*
		Class : View
		Déscription : Permet de gérer les vues
	 */
	class View {
		protected $Model;
		protected $Sections = array();
		
		private $_controller;
		private $_action;
		private $_layout = "default";

		/*
		  Constructeur
		 */
		public function __construct() {
		}
		
		/**
		 * view -> la méthode complète d'appel à une vue
		 * @param type $controller
		 * @param type $action
		 * @param type $compact
		 */
		public function view($model, $contentType = "", $responseCode = 200){
			if(!isset($model))
				throw new Adapter\ViewException(Adapter\ViewException::getNO_MODEL(), array("controller" => $controller, "action" => $action));
			
			$this->Model = $model;
			
			// Mise en cache de la vue
			$this->beginSection();
			include __view_directory__ . "/" . ucfirst($this->_controller) . "/" . $this->_action . ".php";
			$this->endSection('body');
			// Et on inclue le layout/vue
			if(file_exists(__layout_directory__ . "/" . $this->_layout .".php")){
				$this->beginSection();
				include(__layout_directory__ . "/" . $this->_layout .".php");
				$this->endSection('layout');

				$this->render($this->Sections['layout'], $contentType, $responseCode);
			}
			else
				throw new Adapter\ViewException(Adapter\ViewException::getBAD_LAYOUT(), array('layout' => $this->_layout));
		}
		
		/**
		 * containsTitle -> retourne vrai si la chaine contient la balise title
		 * @param type $string
		 * @return type
		 */
		public function containsTitle($string){
			return !empty($string) && strpos($string, "<title>") !== false;
		}
		
		/**
		 * render -> affiche le html passé en paramètre
		 * @param mixed $string
		 */
		public function render($mixed, $contentType = "", $responseCode = 200){
			if(empty($contentType))
				$contentType = 'html';

			header('Content-type: ' . ContentType::getContentType($contentType));
			http_response_code($responseCode);
			
			if(is_string($mixed)){
				echo $mixed;
			}
			else {
				foreach ($mixed as $key => $value) {
					echo $value;
				}
			}
		}

		public function beginSection(){
			// Mise en cache de la vue
			ob_start();
		}

		public function endSection($sectionName){
			$this->Sections[$sectionName] = ob_get_clean();
		}
		
		/***********
		 * SETTERS *
		 ***********/
		public function setLayout($layout){
			$this->_layout = $layout;
		}
		public function setController($controller){
			$this->_controller = $controller;
		}
		public function setAction($action){
			$this->_action = $action;
		}
		
		/***********
		 * GETTERS *
		 ***********/
		public function getLayout(){
			return $this->_layout;
		}
		public function getController(){
			return $this->_controller;
		}
		public function getAction(){
			return $this->_action;
		}
	}
