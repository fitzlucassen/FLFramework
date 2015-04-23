<?php
	 
	namespace fitzlucassen\FLFramework\Library\Core;

	/*
		Class : Cache
		Déscription : Permet de gérer le cache (mise en cache de requête ou de vue)
	 */
	class Cache {
		private static $_cacheFolder = '';
		private static $_expireTime = 86400; // Un jour

		/**
		 * write --> Ecrit une requête en cache
		 * @param string $key
		 * @param object $text
		 * @return object
		 */
		public static function write($key, $text){
			if(!is_dir(self::$_cacheFolder))
				mkdir(self::$_cacheFolder);
			
			file_put_contents(self::$_cacheFolder . $key, serialize($text));
			
			return $text;
		}
		
		/**
		 * read --> retourne le contenu du cache sur une certaine clef, si cette clef existe
		 * @param string $key
		 * @return boolean/object
		 */
		public static function read($key){
			if(!is_dir(self::$_cacheFolder))
				mkdir(self::$_cacheFolder);

			if(file_exists(self::$_cacheFolder . $key)){
				if(filemtime(self::$_cacheFolder . $key) + self::$_expireTime <= time()){
					self::delete($key);
					return false;
				}
				return unserialize(file_get_contents(self::$_cacheFolder . $key));
			}
			else
				return false;
		}
		
		/**
		 * delete --> supprime un élément du cache via sa clef
		 * @param string $key
		 */
		public static function delete($key){
			unlink(self::$_cacheFolder . $key);
		}
		
		/**
		 * clear --> supprime tous les élément du cache
		 */
		public static function clear(){
			foreach(glob(self::$_cacheFolder . '*') as $file){
				self::delete($file);
			}
		}
		
		/***********
		 * GETTERS *
		 ***********/
		public static function getCacheFolder(){
			return self::$_cacheFolder;
		}
		   
		/***********
		* SETTERS *
		***********/
		public static function setCacheFolder($arg){
			self::$_cacheFolder = $arg;
		}
		public static function setExpireTime($arg){
			self::$_expireTime = $arg;
		}
	}
