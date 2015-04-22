<?php
	namespace fitzlucassen\FLFramework\Library\Core;
	
	class Locale {
		private static $_locales = [
			'fr' => 'fr_FR',
			'en' => 'en_US',
			'es' => 'es_ES'
		];

		/**
		 * getContentType --> Return the content type of wish type
		 * @param string $key
		 * @return string
		 */
		public static function getLocale($key){
			return self::$_locales[$key];
		}
	}