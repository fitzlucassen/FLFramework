<?php
	namespace fitzlucassen\FLFramework\Library\Core;
	
	class Locale {
		private static $_locales = [
			'fr' => 'fr_FR',
			'en' => 'en_US',
			'es' => 'es_ES'
		];

		/**
		 * getLocale --> return the locale thanks to the country code
		 * @param string $key
		 * @return string
		 */
		public static function getLocale($key){
			return self::$_locales[$key];
		}

		public static function addLocales($mixed){
			if(is_array($mixed)){
				foreach ($mixed as $key => $value) {
					self::$_locales[$key] = $value;
				}
			}
		}
	}