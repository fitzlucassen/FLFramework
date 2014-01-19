<?php
    class Auth {
	private static $_user = null;
	private static $_pdo = null;
	
	public static function connect($login, $pwd) {
	    $UserRepository = new UserRepository(self::$_pdo, Session::Read("lang"));
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

	public static function disconnect() {
	    Session::clear("Auth");
	}
	
	/***********
	 * GETTERS *
	 ***********/
	public static function getUser() {
	    return self::$_user;
	}
	
	public static function getPdo(){
	    return self::$_pdo;
	}
	
	/***********
	 * SETTERS *
	 ***********/
	public static function setPdo($arg){
	    self::$_pdo = $arg;
	}
    }