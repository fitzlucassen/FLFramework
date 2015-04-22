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
			if (!$this->session_is_active()) {
				session_start();
			}
		}

		/*
		  write
		  Enegistrer une donnée en session
		 */
		public function write($key, $value) {
			$_SESSION[$key] = $value;
		}

		/*
		  read
		  Lire une donnée en session
		 */
		public function read($key) {
			return (array_key_exists($key, $_SESSION)) ?
				$_SESSION[$key] :
				false;
		}

		/*
		  clear
		  supprime une donnée en session
		 */
		public function clear($key) {
			unset($_SESSION[$key]);
		}

		/*
		  clearAll
		  supprime toute la session
		 */
		public function clearAll() {
			session_destroy();
		}

		/*
		  containsKey
		  Retourne vrai si une clé existe en session
		 */
		public function containsKey($key) {
			return (isset($_SESSION[$key]));
		}

		private function session_is_active() {
			$setting = 'session.use_trans_sid';
			$current = ini_get($setting);

			if (FALSE === $current)
				throw new UnexpectedValueException(sprintf('Setting %s does not exists.', $setting));

			$testate = "mix$current$current";
			$old = @ini_set($setting, $testate);
			$peek = @ini_set($setting, $current);
			$result = $peek === $current || $peek === FALSE;

			return $result;
		}
	}
