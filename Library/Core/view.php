<?php
     
    namespace fitzlucassen\FLFramework\Library\Core;

    /*
      Class : View
      Déscription : Permet de gérer les vues
     */
    class View {
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
	    $Model = $model;
	    include $view;
	}
	
	/**
	 * ViewCompact -> la méthode complète d'appel à une vue
	 * @param type $controller
	 * @param type $action
	 * @param type $compact
	 */
	public function ViewCompact($controller, $action, $compact){
	    if(!isset($compact['Model']))
		throw new ViewException(array("controller" => $controller, "action" => $action));
	    
	    $Model = $compact['Model'];
	    $Model->_controller = $controller;
	    $Model->_action = $action;
	    
	    // Mise en cache de la vue
	    ob_start();
	    include __view_directory__ . "/" . $Model->_controller . "/" . $Model->_action . ".php";
	    $content = ob_get_clean();
	    
	    // On récupère le contenue en cache
	    $Model->_head = $head;
	    $Model->_content = $content;	    
	    
	    // Et on inclue le layout/vue
	    include(__view_directory__ . "/layout.php");
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
	
	/**
	 * RegisterViewHead -> enregistre le head de la vue
	 * @return type
	 */
	public function RegisterViewHead(){
	    $head = ob_get_clean();
	    ob_start();
	    
	    return $head;
	}
    }