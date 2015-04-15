<?php
	/*
		Class : String
		Déscription : Permet de gérer les strings
	*/
	 
	namespace fitzlucassen\FLFramework\Library\Adapter;

	class StringAdapter {
		/**
		 * Sanitize -> Clean une string pour faire une URL
		 * @param type $string
		 * @return type
		 */
		public static function Sanitize($string) {
			$string = strtolower($string);
			$string = str_replace(" ", "-", $string);
			$string = str_replace("'", "-", $string);
			$string = str_replace(",", "-", $string);
			$string = str_replace("?", "-", $string);
			$string = str_replace("!", "-", $string);
			$string = str_replace(":", "-", $string);
			$string = str_replace(";", "-", $string);
			$string = str_replace("é", "e", $string);
			$string = str_replace("è", "e", $string);
			$string = str_replace("ê", "e", $string);
			$string = str_replace("à", "a", $string);
			$string = str_replace("â", "a", $string);
			$string = str_replace("ù", "u", $string);
			$string = str_replace("û", "u", $string);
			$string = str_replace("ï", "i", $string);
			$string = str_replace("î", "i", $string);
			$string = str_replace("ì", "i", $string);
			$string = str_replace("ô", "o", $string);
			$string = str_replace("ö", "o", $string);
			$string = str_replace("--", "-", $string);
			$string = str_replace("+", "", $string);
			$string = str_replace("%", "", $string);
			$string = str_replace("*", "x", $string);

			$string = rtrim($string, "-");
			$string = ltrim($string, "-");
			return $string;
		}

		public static function IsNullOrEmpty($string){
			return !isset($string) || empty($string);
		}
	}
