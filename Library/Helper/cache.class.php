<?php
    class Cache {
	private static $_cacheFolder = '/Cache/';
	private static $_expireTime = 86400; // Un jour

	public static function write($key, $text){
	    file_put_contents(self::$_cacheFolder . $key, serialize($text));
	    
	    return $text;
	}
	
	public static function read($key){
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
	
	public static function delete($key){
	    unlink(self::$_cacheFolder . $key);
	}
	
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