<?php
     
    namespace fitzlucassen\FLFramework\Library\Helper;

    /*
      Class : Auth
      Déscription : Permet de gérer la couche autentification. (Connexion / Deconnexion d'un utilisateur)
     */
    class Auth extends Helper{
	private static $_user = null;
	private static $_repositoryManager = null;
	
	/**
	 * connect --> connecte un utilisateur en session s'il existe en bdd retourne faux sinon
	 * @param object $manager
	 * @return boolean/User
	 */
	public static function connect($manager) {
	    $this->_repositoryManager = $manager;
	    
	    $UserRepository = $this->_repositoryManager->get('User');
	    $user = $UserRepository->getByLogin($login, $pwd);
	    
	    if(array_key_exists($user, 'id')){
		Session::Write("Auth", $user['id']);
		self::$_user = $user;
		return self::$_user;
	    }
	    else{
		return false;
	    }
	}

	/**
	 * disconnect --> déconnecte un utilisateur de la session courante
	 */
	public static function disconnect() {
	    Session::clear("Auth");
	}
	
	/***********
	 * GETTERS *
	 ***********/
	public static function getUser() {
	    return self::$_user;
	}
    }