<?php
     
    namespace fitzlucassen\FLFramework\Library\Helper;

    /*
      Class : Session
      Déscription : Permet de gérer les données de session
     */
    class Session extends Helper {
		/*
		  Constructeur
		 */
		public function __construct() {
			parent::__construct();
		}

		/*
		  write
		  Enegistrer une donnée en session
		 */
		public function Write($key, $value) {
		    $_SESSION[$key] = $value;
		}

		/*
		  read
		  Lire une donnée en session
		 */
		public function Read($key) {
		    return (array_key_exists($key, $_SESSION)) ?
			    $_SESSION[$key] :
			    false;
		}

		/*
		  clear
		  supprime une donnée en session
		 */
		public function Clear($key) {
		    unset($_SESSION[$key]);
		}

		/*
		  containsKey
		  Retourne vrai si une clé existe en session
		 */
		public function ContainsKey($key) {
		    return (isset($_SESSION[$key]));
		}
    }