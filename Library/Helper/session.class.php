<?php
    /*
      Class : Session
      Déscription : Permet de gérer les données de session
     */
    class Session extends Helper {
	/*
	  Constructeur
	 */
	public function __construct($controller) {
	    parent::__construct($controller);
	}

	/*
	  write
	  Enegistrer une donnée en session
	 */
	public static function Write($key, $value) {
	    $_SESSION[$key] = $value;
	}

	/*
	  read
	  Lire une donnée en session
	 */
	public static function Read($key) {
	    return (array_key_exists($key, $_SESSION)) ?
		    $_SESSION[$key] :
		    false;
	}

	/*
	  clear
	  supprime une donnée en session
	 */
	public static function Clear($key) {
	    unset($_SESSION[$key]);
	}

	/*
	  containsKey
	  Retourne vrai si une clé existe en session
	 */
	public static function ContainsKey($key) {
	    return (isset($_SESSION[$key]));
	}
    }