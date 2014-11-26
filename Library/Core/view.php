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
		 * View -> appelle une vue le plus simplement possible
		 * @param type $view
		 * @param type $model
		 */
		public function View($view, $model = array()){
			$this->Model = $model;
			include __view_directory__ . '/' . $view;
		}
		
		/**
		 * ViewCompact -> la méthode complète d'appel à une vue
		 * @param type $controller
		 * @param type $action
		 * @param type $compact
		 */
		public function ViewCompact($model){
			if(!isset($model))
				throw new Adapter\ViewException(Adapter\ViewException::getNO_MODEL(), array("controller" => $controller, "action" => $action));
			
			$this->Model = $model;
			
			// Mise en cache de la vue
			$this->BeginSection();
			include __view_directory__ . "/" . ucfirst($this->_controller) . "/" . $this->_action . ".php";
			$this->EndSection('body');
			
			// Et on inclue le layout/vue
			if(file_exists(__layout_directory__ . "/" . $this->_layout .".php"))
				include(__layout_directory__ . "/" . $this->_layout .".php");
			else
				throw new Adapter\ViewException(Adapter\ViewException::getBAD_LAYOUT(), array('layout' => $this->_layout));
		}
		
		/**
		 * ContainsTitle -> retourne vrai si la chaine contient la balise title
		 * @param type $string
		 * @return type
		 */
		public function ContainsTitle($string){
			return !empty($string) && strpos($string, "<title>") !== false;
		}
		
		/**
		 * Render -> affiche le html passé en paramètre
		 * @param type $string
		 */
		public function Render($string){
			echo $string;
		}

		public function BeginSection(){
			// Mise en cache de la vue
			ob_start();
		}

		public function EndSection($sectionName){
			$this->Sections[$sectionName] = ob_get_clean();
		}
		
		/***********
		 * SETTERS *
		 ***********/
		public function SetLayout($layout){
			$this->_layout = $layout;
		}
		public function SetController($controller){
			$this->_controller = $controller;
		}
		public function SetAction($action){
			$this->_action = $action;
		}
		
		/***********
		 * GETTERS *
		 ***********/
		public function GetLayout(){
			return $this->_layout;
		}
		public function GetController(){
			return $this->_controller;
		}
		public function GetAction(){
			return $this->_action;
		}
    }