<?php
	/*
		Class : String
		Déscription : Permet de gérer les strings
	*/
	 
	namespace fitzlucassen\FLFramework\Library\Adapter;

	class StringAdapter {
		/**
		 * Sanitize -> Clean une string pour faire une URL
		 * @param string $string
		 * @return string
		 */
		public static function sanitize($string) {
		    $string = strtolower($string);

		    $search = [
		    	' ','\'',',','?','!',':',';','é','è','ê','à','â','ù','ï','î','ô','ö','--','+','%','*','/'
		    ];
		    $replace = [
		    	'-','-','-','-','-','-','-','e','e','e','a','a','u','i','i','o','o','-','','','x',''
		    ];
		    $string = str_replace($search, $replace, $string);

		    $string = rtrim($string, "-");
		    $string = ltrim($string, "-");
		    return $string;
		}

		/**
		 * IsNullOrEmpty --> tell is a string is null or empty
		 * @param string $string
		 * @return string
		 */
		public static function isNullOrEmpty($string){
			return !isset($string) || empty($string);
		}

		public static function startsWith($haystack, $needle){
			return strpos($haystack, $needle) === 0;
		}

		public static function endsWith($haystack, $needle){
			if(strlen($needle) > strlen($haystack))
				return false;
			else {
				$i = strrpos($haystack, $needle);
				if($i >= 0 && substr($haystack, $i, strlen($needle)) == $needle)
					return strrpos($haystack, $needle) + strlen($needle) === strlen($haystack);
				else
					return false;
			}
		}
	}
