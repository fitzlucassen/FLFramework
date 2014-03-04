<?php
     
    namespace fitzlucassen\FLFramework\Library\Helper;
    
    /*
      Class : Email
      Déscription : Permet de gérer l'envoie d'e-mail
     */
    class Email extends Helper {
		private $_from;
		private $_fromName;
		private $_subject;
		private $_to;
		private $_header;
		private $_view;
		private $_layout;
		private $_carriage_return;
		private $_vars;

		public function __construct($params = null) {
			parent::__construct();
			$this->_layout = "email";
			$this->_view = "default";
		}

		/**
		 * SetCarriageReturn --> Définie le retour chariot selon la boite mail
		 */
		private function setCarriageReturn() {
		    if (!empty($this->_to)) {
				if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $this->_to))
				    $this->_carriage_return = "\r\n";
				else
				    $this->_carriage_return = "\n";
		    }
		}
		
		/***********
		 * SETTERS *
		 ***********/
		public function from($from) {
		    $this->_from = $from;
		    return $this;
		}
		public function to($to) {
		    $this->_to = $to;
		    return $this;
		}
		public function subject($subject) {
		    $this->_subject = $subject;
		    return $this;
		}
		public function fromName($pseudo) {
		    $this->_fromName = $pseudo;
		    return $this;
		}
		public function layout($layout){
			$this->_layout = $layout;
			return $this;
		}
		public function view($view){
			$this->_view = $view;
			return $this;
		}
		public function vars($vars){
			if(is_array($vars))
				$this->_vars = $vars;
			else
				return false;
			return $this;
		}

		/**
		 * BuildHeaders -> Construit les header de l'e-mail
		 * @return \Mail
		 */
		public function buildHeaders() {
			$this->setCarriageReturn();

		    $this->headers = 'MIME-Version: 1.0' . $this->_carriage_return;
		    $this->headers .= 'Content-type: text/html; charset=UTF-8' . $this->_carriage_return;

		    $this->headers .= 'To: ' . $this->_to . $this->_carriage_return;
		    $this->headers .= 'From: FLFramework, Personne : ' . $this->_fromName . ' <' . $this->_from . '>' . $this->_carriage_return;

		    return $this;
		}

		/**
		 * Send --> Send an e-mail previously constructed
		 */
		public function send() {
			foreach ($this->_vars as $key => $value) {
				$$key = $value;
			}
			// Mise en cache de la vue
		    ob_start();
		    include __view_directory__ . "/Email/" . $this->_view . ".php";
		    $content = ob_get_clean();

		    $__head = $head;
		    $__content = $content;

		    ob_start();
		    include(__layout_directory__ . "/" . $this->_layout .".php");
		    $email = ob_get_clean();


		    var_dump($email);die();
		    mail($this->_to, $this->_subject, $email, $this->_header);
		}

		/**
		 * Render -> affiche le html passé en paramètre
		 * @param type $string
		 */
		public function render($string){
		    echo $string;
		}
		
		/**
		 * RegisterViewHead -> enregistre le head de la vue
		 * @return type
		 */
		public function registerViewHead(){
		    $head = ob_get_clean();
		    ob_start();
		    
		    return $head;
		}

		/**
		 * ContainsTitle -> retourne vrai si la chaine contient la balise title
		 * @param type $string
		 * @return type
		 */
		public function containsTitle($string){
		    return !empty($string) && strpos($string, "<title>") !== false;
		}
    }