<?php
	namespace fitzlucassen\FLFramework\Library\Core;
	
	class ContentType {
		private static $_contentType = [
			'json' => 'application/json',
			'xml' => 'text/xml',
			'text' => 'text/plain',
			'html' => 'text/html'
		];

		/**
		 * getContentType --> Return the content type of wish type
		 * @param string $key
		 * @return string
		 */
		public static function getContentType($key){
			return self::$_contentType[$key];
		}

		public static function addContentTypes($mixed){
			if(is_array($mixed)){
				foreach ($mixed as $key => $value) {
					self::$_contentType[$key] = $value;
				}
			}
		}
	}