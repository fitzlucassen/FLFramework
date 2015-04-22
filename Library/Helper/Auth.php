<?php
	 
	namespace fitzlucassen\FLFramework\Library\Helper;

	/*
		Class : Auth
		Déscription : Permet de gérer la couche autentification. (Connexion / Deconnexion d'un utilisateur)
	 */
	class Auth extends Helper{
		private $_siteKey = "fitzlucassen\FLFramework";
		private $_user = null;
		private $_repositoryManager = null;
		private $_session = null;
		private $_params = array(
			'table' => 'user',
			'primaryKeyField' => 'id',
			'loginField' => 'login',
			'passwordField' => 'password',
			'adminField' => 'isAdmin',
			'encryptedPassword' => true
		);
		
		/**
		 * Constructeur
		 * @param $manager
		 * @param $params
		 */
		public function __construct($manager, $params = null){
			$this->_repositoryManager = $manager;
			$this->_session = new Session();

			if(isset($params) && is_array($params)){
				$this->_params = array_merge($this->_params, $params);
			}
		}
		/**
		 * connect --> connecte un utilisateur en session s'il existe en bdd retourne faux sinon
		 * @param object $manager
		 * @return boolean/User
		 */
		public function connect($login, $pwd) {
			$UserRepository = $this->_repositoryManager->get(ucwords($this->_params['table']));

			$user = $UserRepository->getBy($this->_params['loginField'], $login);
			$attrPwd = 'get' . ucwords($this->_params['passwordField']);
			
			$attr = 'get' . ucwords($this->_params['primaryKeyField']);

			if(isset($user) && count($user) > 0){
				if(is_array($user))
					$user = $user[0];
				
				$id = $user->$attr();

				if(isset($id) && !empty($id) && $id > 0 && $user->$attrPwd() == $this->hashData($pwd)){
					$this->_session->write("Auth", $id);
					$this->_user = $user;
					return $this->_user;
				}
				else{
					return false;
				}
			}
			else {
				return false;
			}
		}

		/**
		 * disconnect --> déconnecte un utilisateur de la session courante
		 */
		public function disconnect() {
			$this->_session->clear("Auth");
			$this->_user = null;
		}

		/**
		 * isAdmin -> retourne vrai si le user est administrateur
		 * @return boolean
		 */
		public function isAdmin(){
			$attr = 'get' . ucwords($this->_params['adminField']) . '()';
			if(isset($this->_user) && $this->_user->$attr){
				return true;
			}
			else
				return false;
		}

		private function hashData($data){
			return md5($data);
		}
		
		/***********
		 * GETTERS *
		 ***********/
		public function getUser() {
			return $this->_user;
		}
	}
