<?php
	namespace fitzlucassen\FLFramework\Library\Helper;

	class Token extends Helper {
		private static $_privateKey = "efzfzdiuhzdiuzezouzhdazdpij";
		private static $_validityTime = 3;

		/**
		 * getToken --> get a securized token
		 * @return string $token
		 */
		public static function getToken(){
			$token = self::$_privateKey . "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] . $_SERVER['HTTP_USER_AGENT'];
			$informations = time();
			$token = hash('sha256', $token . $informations);

			setcookie('HTTP_SIGNATURE', $token, time() + self::$_validityTime);
			setcookie('HTTP_INFORMATIONS', $informations, time() + self::$_validityTime);
			return $token;
		}

		/**
		 * compareToken --> compare request token with cookified token
		 * @param string $token
		 * @return boolean
		 */
		public static function compareToken($token){
			$myToken = self::$_privateKey . "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] . $_SERVER['HTTP_USER_AGENT'];

			if(array_key_exists('HTTP_SIGNATURE', $_COOKIE)){
				//on recrypte avec les informations transmises dans le cookie en clair
				$myToken = hash('sha256', $myToken . $_COOKIE['HTTP_INFORMATIONS']);

				//On compare le hash calculé avec le hash passé en cookie
				if(strcmp($_COOKIE['HTTP_SIGNATURE'], $token) == 0){
					// On vérifie que la session n'est pas expirée
				  	if($_COOKIE['HTTP_INFORMATIONS'] + self::$_validityTime > time() AND $_COOKIE['HTTP_INFORMATIONS'] < time())
						return true;
				}
				else
					return false;
			}
			else
				return false;
		}
	}