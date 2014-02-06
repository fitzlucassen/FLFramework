<?php
     
    namespace fitzlucassen\FLFramework\Library\Helper;

    /*
      Class : Logger
      Déscription : Permet de gérer les logs (trâcage du parcours du programme)
     */
    class Logger {
	private static $_logFile = "/Logs/log.txt";
	private static $_expireTime = 86400; // Un jour
	
	/**
	 * write --> écrit un message dans le fichier de log
	 * @param string $message
	 * @param boolean $append
	 */
	public static function write($message, $append = false){
	    date_default_timezone_set('Europe/Paris');
	    $date = date('d-m-y H:i:s');
	    $fileDate = filemtime(self::$_logFile);
	    
	    $isExpired = $fileDate + self::$_expireTime <= time();
	    
	    if($isExpired)
		self::changeLogFile();
	    
	    if($append || !$isExpired)
		file_put_contents(self::$_logFile, file_get_contents(self::$_logFile) . $date . ' --> ' . $message . "\n");
	    else
		file_put_contents(self::$_logFile, $date . ' --> ' . $message . "\n");
	}
	
	/**
	 * read --> retourne le contenu du fichier de log courant
	 * @return string
	 */
	public static function read(){
	    return file_get_contents(self::$_logFile);
	}
	
	/**
	 * changeLogFile --> Lorsque le fichier de log est expiré, on l'archive et on en crée un autre
	 */
	private static function changeLogFile(){
	    $t = substr(self::$_logFile, 0, strlen(self::$_logFile)-4);
	    $t .= " " . date('dmy-His') . ".txt";
	    
	    $handle = fopen($t, "a+");
	    fwrite($handle, file_get_contents(self::$_logFile));
	    fclose($handle);
	    
	    file_put_contents(self::$_logFile, "");
	}
	
	/***********
	 * SETTERS *
	 ***********/
	public static function setLogFile($arg){
	    self::$_logFile = $arg;
	}
	public static function setExpireTime($arg){
	    self::$_expireTime = $arg;
	}
    }
